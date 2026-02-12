<?php

////////*********//////
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\adm;

use App\Helper\CMPDF;

use App\Models\employee;
use App\Models\re_megration;
use Illuminate\Http\Request;
use App\Models\rend_megration;


class RendementController extends Controller
{
    private $_retenues_inds = [610, 980, 660, 399, 397, 398, 999];
    private $_primes_family_inds = [992, 991, 990, 401];
    private $_primes_base_inds = [001, 101];

    public function index(Request $request)
    {
        $adms = adm::all();
        //variable search has the input from search input
        $search = $request->input('search');
       

        /*var $loginAFFECT is shared by all views  in boot of service provider
        // dd( array_keys($request->sitpai));
        $adms = adm::all();
        //variable search has the input from search input
        $search = $request->input('search');
        $adms_select = $request->adms_select;

        /*var $loginAFFECT is shared by all views  in boot of service provider
         this the way how to call it in  the controller (difference with call in view)
          $loginAFFECT has the establishement AFFECT value of sign in user */
     
            $employees = employee::with(["establishment", "fonction"]);
     
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

        // dd($employees->toSql());
        $employees =  $employees->paginate(12);
        // Append the search parameter to the pagination links
        /* it resolve the pbm that when i click the cursor of paginator return all employees
         without search conditions */
        $employees->appends(['search' => $search]);


        // returning view employees-list with passing parametre employees
        //dd($adms_select);
        return view('admin/rendement/employees-list', ["employees" => $employees, "adms" => $adms, "select_adms" => $select_adms, "select_sitpai" => $select_sitpai, "search" => $search]);
    }


    public function rendement_single_list($MATRI)
    {
        //one record (first)
        $employee = employee::where("MATRI", $MATRI)->first();
        //all the records (get)
        $rendement_singles = rend_megration::with('re_megration')
        ->where('MATRI', $MATRI)
        ->join('re_megrations', 'rend_megrations.ID_MEGRATION_RE', '=', 're_megrations.ID_MEGRATION_RE')
        ->orderBy('re_megrations.YEAR', 'DESC')
        ->orderBy('re_megrations.TRIMESTRE', 'DESC')
        ->select('rend_megrations.*') // Avoid duplicate columns from join
        ->paginate(10);

        return view('admin/rendement/single/list', ["rendement_singles" => $rendement_singles, "employee" => $employee]);
    }



    public function rendement_single_print(Request $request)
    {
        // to get record (first) of employee with matri sent from request
        $employee = employee::where("MATRI", $request->MATRI)->first();
        //dd($request);
        // to get record (first) of emp_megration join megration join fonction
        // with matri and adm and id_megration sent from request
        $rend_bill = rend_megration::where("MATRI", $request->MATRI)
            ->where("ADM", $request->ADM)
            ->where("ID_MEGRATION_RE", $request->IDMEGR)
            ->first();


        // to get array of records (get) of grant join grant_inf
        // with matri and adm and id_megration sent from request

        // $salary_grants = grant::with("grant_info")->where("MATRI", $request->MATRI)
        //     ->where("ADM", $request->ADM)
        //     ->where("ID_MEGRATION", $request->ID_MEGRATION)
        //     ->get();

        //empty arrays of arrays  to devide salary grants

        // pushing elements in empty arrays
        //first by verifying sens in grant_info_in salary grant
        //second by comparing les indices de salary_grant with the constants arrays in top

        // $serv =  Establishment::where('estab_micano',  $micano)->first();
        // $rend_bill =   rend_megration::where("MATRI", $request->MATRI)->where("rw_re_bill_migrations_id", $request->rw_re_bill_migrations_id)->first();
        if (!defined('_MPDF_TTFONTPATH')) {
            // an absolute path is preferred, trailing slash required:
            define('_MPDF_TTFONTPATH', realpath('theme/font'));
            // example using Laravel's resource_path function:
            //define('_MPDF_TTFONTPATH', public_path('theme/font'));
        }

        //emp_megrations_to_print is variable has variables to send to pdf files
        //$emp_megrations is my array of arrays result by deviding salary grant

        $mpdf = new CMPDF();
        $mpdf->initialize();
        $mpdf->viewToPDF('admin/rendement/single/rendement_print', ["rend_bill" =>  $rend_bill]);

        $mpdf->outPut('I');
    }

    

    public function getTableContent()
{
    $data = // Fetch your data here
    $htmlContent = View::make('your.pdf_view_file', compact('data'))->render();
    return response()->json(['html' => $htmlContent]);
}
}
