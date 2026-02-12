<?php

namespace App\Http\Controllers\Director;
use App\Http\Controllers\Controller;

use App\Models\adm;
use App\Helper\CMPDF;
use App\Models\grant;
use App\Models\employee;
use App\Models\fonction;
use App\Models\megration;
use App\Models\grant_info;
use Illuminate\Http\Request;
use App\Models\emp_megration;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;


class DirectorSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)

    {


        // dd( array_keys($request->sitpai));
        $adms = adm::all();
        //variable search has the input from search input
        $search = $request->input('search');
        $adms_select = $request->adms_select;

        /*var $loginAFFECT is shared by all views  in boot of service provider
        // dd( array_keys($request->sitpai));
        $adms = adm::all();
        //variable search has the input from search input
        $search = $request->input('search');
        $adms_select = $request->adms_select;

        /*var $loginAFFECT is shared by all views  in boot of service provider
         this the way how to call it in  the controller (difference with call in view)
          $loginAFFECT has the establishement AFFECT value of sign in user */
        $establishment = session()->get("establishment");
        if (env("APP_ENV", "local") == "local")
            $employees = employee::with(["establishment", "fonction"])->where("AFFECT", "390904");
        else
            $employees = employee::with(["establishment", "fonction"])->where("AFFECT",  $establishment->estab_rawateb_user);

        //dd($employees);
        $select_adms = [];

        if ($request->has("adms")) {
            $select_adms =  array_keys($request->adms);
            $employees = $employees->whereIn("ADM",  $select_adms);
        }
        $select_sitpai = [0];
        if ($request->has("sitpai")) {
            $select_sitpai =  array_keys($request->sitpai);
            $employees = $employees->whereIn("SITPAI",   $select_sitpai);
        }


        if (isset($search) && !empty($search)) {
            $employees =    $employees->where(function ($query) use ($search) {
                $query->where('NOMA', 'like', '%' . $search . '%')
                    ->orWhere('PRENOMA', 'like', '%' . $search . '%')
                    ->orWhere('MATRI', 'like', '%' . $search . '%');
            });
        }   //to paginate it change ->get by ->paginate(12);

        $employees =  $employees->paginate(12);

        // Append the search parameter to the pagination links
        /* it resolve the pbm that when i click the cursor of paginator return all employees
         without search conditions */
        // dd(request()->input());
        $employees->appends(['search' => $search]);

        // returning view employees-list with passing parametre employees
        //dd($adms_select);
        return view('director/salary/employees-list', ["employees" => $employees, "adms" => $adms, "select_adms" => $select_adms, "select_sitpai" => $select_sitpai, "search" => $search]);
    }

    /**
      fun : view megration of employe single
     */

    /*   public function salary_single_list($MATRI)
    /*   public function salary_single_list($MATRI)
    {
        $establishment = session()->get("establishment");
        $employees = employee::where("AFFECT", $establishment->estab_rawateb_user)->get();
        return view('salary/employees-list', ["employees" => $employees]);
    } */

    //arrays to devide the salary grants by their indices using inarray and push
    private $_primes_family_inds = [992, 991, 990, 401];
    private $_primes_base_inds = [001, 101];
    private $_retenues_inds = [610, 980, 660, 399, 397, 398, 999];


    /**
     * funtion : view megration list of employe single
     */

    public function salary_single_list($MATRI)
    {
        //one record (first)
        $employee = employee::where("MATRI", $MATRI)->first();
        //all the records (get)
        $salary_singles = emp_megration::join("megrations","megrations.ID_MEGRATION","emp_megrations.ID_MEGRATION")
        ->where("emp_megrations.MATRI", $MATRI)
        ->where("megrations.active", 1)
         ->orderBy("YEAR", "DESC")->orderBy("MONTH", "DESC")
        ->get()->groupBy(function ($data) {
            return $data->megration->YEAR;
        });
        //dd( $salary_singles);
        //passing 2 variables (employee, salary_singles) with returning view salary/single/list
        return view('director/salary/single/list', ["salary_single_years" => $salary_singles, "employee" => $employee]);
    }


    public function salary_single_print(Request $request)
    {


        // to get record (first) of employee with matri sent from request
        $employee = employee::where("MATRI", $request->MATRI)->first();

        // to get record (first) of emp_megration join megration join fonction
        // with matri and adm and id_megration sent from request
        $salary_single = emp_megration::with(["megration", "fonction"])->where("MATRI", $request->MATRI)
            ->where("ADM", $request->ADM)
            ->where("ID_MEGRATION", $request->ID_MEGRATION)
            ->first();

        // to get array of records (get) of grant join grant_inf
        // with matri and adm and id_megration sent from request
        $salary_grants = grant::with("grant_info")->where("MATRI", $request->MATRI)
            ->where("ADM", $request->ADM)
            ->where("ID_MEGRATION", $request->ID_MEGRATION)
            ->get();
        //empty arrays of arrays  to devide salary grants
        $emp_megrations["retenues"] = [];
        $emp_megrations["primes"] = [];

        $emp_megrations["primes"]["base"] = [];
        $emp_megrations["primes"]["family"] = [];
        $emp_megrations["primes"]["other"] = [];

        $emp_megrations["retenues"]["other"] = [];
        $emp_megrations["retenues"]["inds"] = [];

        // pushing elements in empty arrays
        //first by verifying sens in grant_info_in salary grant
        //second by comparing les indices de salary_grant with the constants arrays in top
        foreach ($salary_grants as $salary_grant) {

            if ($salary_grant->grant_info->SENS == "+") {
                if (in_array($salary_grant->IND, $this->_primes_base_inds))
                    array_push($emp_megrations["primes"]["base"], $salary_grant);
                else  if (in_array($salary_grant->IND, $this->_primes_family_inds))
                    array_push($emp_megrations["primes"]["family"], $salary_grant);
                else
                    array_push($emp_megrations["primes"]["other"], $salary_grant);
            } else {
                if (in_array($salary_grant->IND, $this->_retenues_inds))
                    $emp_megrations["retenues"]["inds"][$salary_grant->IND] = $salary_grant;
                else
                    array_push($emp_megrations["retenues"]["other"], $salary_grant);
            }
        }

        //emp_megrations_to_print is variable has variables to send to pdf files
        //$emp_megrations is my array of arrays result by deviding salary grant
        $emp_megrations_to_print = ['employee' => $employee, "salary_single" => $salary_single, 'salary_grants' => $emp_megrations];
        //dd($emp_megrations_to_print);
        //using cmpdf mehtod in helper
        $mpdf = new CMPDF();
        // $mpdf->initialize(['default_font'=>'Arial','custom_font_dir'=>asset('/Admin3/dist/fonts/')]);
        $mpdf->initialize(['default_font' => 'aegyptus']);
        $mpdf->initialize(['default_font' => 'aegyptus']);
        if ($request->lang == "ar")
            $mpdf->viewToPDF('director/salary/single/pdf-ar', $emp_megrations_to_print);
        else
            $mpdf->viewToPDF('director/salary/single/pdf-fr', $emp_megrations_to_print);
        // I means inline view of pdf
        $mpdf->outPut('I');
    }

}
