<?php

namespace App\Http\Controllers;

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


class SalaryController extends Controller
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
        if ($employees->count() == 0 && isset($search) && !empty($search)) {
            $employees = employee::where("MATRI", $search)->paginate(12);
        }

        // Append the search parameter to the pagination links
        /* it resolve the pbm that when i click the cursor of paginator return all employees
         without search conditions */
        // dd(request()->input());
        $employees->appends(['search' => $search]);

        // returning view employees-list with passing parametre employees
        //dd($adms_select);
        return view('salary/employees-list', ["employees" => $employees, "adms" => $adms, "select_adms" => $select_adms, "select_sitpai" => $select_sitpai, "search" => $search]);
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
        return view('salary/single/list', ["salary_single_years" => $salary_singles, "employee" => $employee]);
    }


    public function salary_single_print(Request $request)
    {

          
        // to get record (first) of employee with matri sent from request
        $employee = employee::where("MATRI", $request->MATRI)->first();
       // dd($employee);

        // to get record (first) of emp_megration join megration join fonction
        // with matri and adm and id_megration sent from request
        $salary_single = emp_megration::with(["megration", "fonction"])->where("MATRI", $request->MATRI)
            ->where("ADM", $request->ADM)
            ->where("ID_MEGRATION", $request->ID_MEGRATION)
            ->first();
        //dd($salary_single);

        // to get array of records (get) of grant join grant_inf
        // with matri and adm and id_megration sent from request
       // dd($request);
        $salary_grants = grant::with("grant_info")->where("MATRI", $request->MATRI)
            ->where("ADM", $request->ADM)
            ->where("ID_MEGRATION", $request->ID_MEGRATION)
            ->get();
        //  dd($salary_grants);
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
            $mpdf->viewToPDF('salary/single/pdf-ar', $emp_megrations_to_print);
        else
            $mpdf->viewToPDF('salary/single/pdf-fr', $emp_megrations_to_print);
        // I means inline view of pdf
        $mpdf->outPut('I');
    }
    /*
    salary single year
                     */
    public function salary_single_year_list($MATRI)
    {
        $employee = employee::where("MATRI", $MATRI)->first();
        $salary_singles = emp_megration::join("megrations","megrations.ID_MEGRATION","emp_megrations.ID_MEGRATION")
        ->where("emp_megrations.MATRI", $MATRI)
        ->where("megrations.active", 1)->get();
        return view('salary/year/list', ["salary_singles" => $salary_singles, "employee" => $employee]);
    }

    public function salary_single_year_print(Request $request)
    {
        //dd($request);
        $employee = employee::where("MATRI", $request->MATRI)->first();
        $salary_single = emp_megration::with(["megration", "fonction"])->where("MATRI", $request->MATRI)
         /*    ->where("ADM", $request->ADM) */
            ->where("ID_MEGRATION", $request->id_megration_select)
            ->first();
        $salary_grants = grant::with("grant_info")->where("MATRI", $request->MATRI)
          /*   ->where("ADM", $request->ADM) */
            ->where("ID_MEGRATION", $request->id_megration_select)
            ->get();



        $emp_megrations["retenues"] = [];
        $emp_megrations["primes"] = [];
        $emp_megrations["primes"]["base"] = [];
        $emp_megrations["primes"]["family"] = [];
        $emp_megrations["primes"]["other"] = [];
        $emp_megrations["retenues"]["other"] = [];
        $emp_megrations["retenues"]["inds"] = [];
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
        $emp_megrations_to_print = ['employee' => $employee, "salary_single" => $salary_single, 'salary_grants' => $emp_megrations];
        $mpdf = new CMPDF();
        $mpdf->initialize();
        if ($request->lang == "ar")
            $mpdf->viewToPDF('salary/year/pdf-ar', $emp_megrations_to_print);
        else
            $mpdf->viewToPDF('salary/year/pdf-fr', $emp_megrations_to_print);

        $mpdf->outPut('I');
    }

    /*
    salary global
                */

    function  salary_global_megration_list()
    {   //get all the megrations order desc
        $megrations = megration::where("active", 1)->orderBy("YEAR", "DESC")->orderBy("MONTH", "DESC")->get();
        $adms = adm::all();
        //passing variable $megrations with returning view
        return view("salary/global/megration_list", ["megrations" => $megrations, "adms" => $adms]);
    }

    function salary_global_view($ID_MEGRATION, Request $request)
    {
        //get all adms
        $adms = adm::all();

        //empty array to sent after the function
        $view_data = [];

        //get megration model record with id megration param sent from view
        $current_megration =  megration::where('ID_MEGRATION', $ID_MEGRATION)->first();

        if ($current_megration === null) {
            return redirect()->back();
        }

        $establishment = session()->get("establishment");

        /*variable emp_megration_query has emp_megration  get records  with complicate query
        the query has aditonal condition if isset the adm select in view */
        //begin query
        //$emp_megrations_query = emp_megration::where("AFFECT", 390904)
        if (env("APP_ENV", "local") == "local")
            $emp_megrations_query = emp_megration::where("AFFECT", 390904);
        else
            $emp_megrations_query = emp_megration::where("AFFECT", $establishment->estab_rawateb_user);

        $emp_megrations_query = $emp_megrations_query->Where("ID_MEGRATION", $current_megration->ID_MEGRATION)
            ->orderBy('ADM');
        /*case of select adm in blade add an condition to the query
         (it called by post method and the param is sent  in request)*/
        if (isset($request->adms_select)) {
            if ($request->adms_select != '0')
                $emp_megrations_query =    $emp_megrations_query->where("ADM", $request->adms_select);
        }
        $emp_megrations = $emp_megrations_query->get();
        //end  query


        /*item is an array has the info of any emp megration record with all grants of this records
          item is an array of key->value (item["key"]=$value)
          2 foreach (1 of emp_megration records infos /2 of all grants of any record) */
        foreach ($emp_megrations  as $emp_megration) {
            //initialise item (empty item) in every foreach session
            $item = [];
            $item["matri"] = $emp_megration->MATRI;
            $item["fullName"] = $emp_megration->employee->NOMA . ' ' . $emp_megration->employee->PRENOMA;
            $item["SITFAM"] = $emp_megration->SITFAM;
            $item["CATEG"] = $emp_megration->CATEG;
            $item["ECH"] = $emp_megration->ECH;
            $item["CATEG"] = $emp_megration->CATEG;
            $item["NBRTRAV"] = $emp_megration->NBRTRAV;
            $item["SALBASE"] = $emp_megration->SALBASE;
            $item["TOTGAIN"] = $emp_megration->TOTGAIN;
            $item["BRUTSS"] = $emp_megration->BRUTSS;
            $item["RETSS"] = $emp_megration->RETSS;
            $item["ADM"] = $emp_megration->ADM;
            $item["RET"] = 0;
            //  filling the grants of this emp_megraion record
            // any grant is filled up by his specified key using Switch case IND
            foreach ($emp_megration->grants  as $grant) {
                switch ($grant->IND) {
                        // الاجر القاعدي
                    case "001":
                        $item["V001"] = $grant->MONTANT;
                        break;
                        // الاجر القاعدي
                    case "105":
                        $item["V105"] = $grant->MONTANT;
                        break;
                    case "280":
                        $item["V280"] = $grant->MONTANT;
                        break;
                    case "241":
                        $item["V241"] = $grant->MONTANT;
                        break;
                        // منحة المنطقة
                    case "225":
                        $item["V225"] = $grant->MONTANT;
                        break;
                        // منحة السكن
                    case "211":
                        $item["V211"] = $grant->MONTANT;
                        break;
                        // المنحة الجزافية
                    case "208":
                        $item["V208"] = $grant->MONTANT;
                        break;
                        // منحة المنصب
                    case "260":
                        $item["V260"] = $grant->MONTANT;
                        break;
                        // منحة التوثيق
                    case "290":
                        $item["V290"] = $grant->MONTANT;
                        break;
                        // منحة التأهيل
                    case "246":
                        $item["V246"] = $grant->MONTANT;
                        break;
                        // منحة الخبرة المهنية
                    case "101":
                        $item["V101"] = $grant->MONTANT;
                        break;
                        // المنحة  البداغوجية
                    case "103":
                        $item["V103"] = $grant->MONTANT;
                        break;
                        // المنح العائلية
                        /// الاجر الوحيد
                    case "401":
                        $item["V401"] = $grant->MONTANT;
                        break;
                        /// اكبر 10 سنوات
                    case "991":
                        $item["V991"] = $grant->MONTANT;
                        break;
                        /// المنحة العائلية
                    case "990":
                        $item["V990"] = $grant->MONTANT;
                        $item["RET"] += $grant->MONTANT;
                        break;
                        /// اقتطاع الضريبة
                    case "980":
                        $item["V980"] = $grant->MONTANT;
                        $item["RET"] += $grant->MONTANT;

                        break;
                        /// اقتطاع التعاضدية
                    case "660":
                        $item["V660"] = $grant->MONTANT;
                        $item["RET"] += $grant->MONTANT;

                        break;
                        /// اقتطاع شرائح
                    case "397":
                        $item["V397"] = $grant->MONTANT;
                        $item["RET"] += $grant->MONTANT;

                        break;
                        /// اقتطاع ديون استهلاكية
                    case "398":
                        $item["V398"] = $grant->MONTANT;
                        $item["RET"] += $grant->MONTANT;

                        break;
                        ///  اقتطاع الخدمات
                    case "399":
                        $item["V399"] = $grant->MONTANT;
                        $item["RET"] += $grant->MONTANT;

                        break;
                        ///  اقتطاع الغياب
                    case "301":
                        $item["V301"] = $grant->MONTANT;
                        $item["RET"] += $grant->MONTANT;
                        break;
                        ///  اقتطاع الاضراب
                    case "302":
                        $item["V302"] = $grant->MONTANT;
                        $item["RET"] += $grant->MONTANT;
                        break;
                        ///  اقتطاع المعارضة
                    case "303":
                        $item["V303"] = $grant->MONTANT;
                        $item["RET"] += $grant->MONTANT;
                        break;
                        ///  الصلفي المدفوع
                    case "999":
                        $item["V999"] = $grant->MONTANT;
                        break;
                    case "270":
                        $item["V270"] = $grant->MONTANT;
                        break;
                    case "273":
                        $item["V273"] = $grant->MONTANT;
                        break;
                }
            } //end 1 foreach

            // pushing the info of this emp_megration in $view_data
            array_push($view_data, $item);
        } // end 2 forech

        /*passing 4 params with returnig view
        (param adms_select is conditonel param (=>0 case the first enter or choose "الكل" in adm_select)
        */
        return view("salary/global/view", ["data" => $view_data, "current_megration" => $current_megration, "adms" => $adms, "adms_select" => $request->adms_select ?? "0"]);
    }

    public function salary_global_print(Request $request)
    {
        // dd($request);
        $current_megration =  megration::where('ID_MEGRATION', $request->ID_MEGRATION)->first();

        if ($current_megration === null) {
            return redirect()->back();
        }


        /*     $emp_megrations = Employee::join('emp_megrations', 'employees.AFFECT', '=', 'emp_megrations.AFFECT')
    ->where('employees.AFFECT', 390904)
    ->where('emp_megrations.ID_MEGRATION', $current_megration->ID_MEGRATION)
    ->where('emp_megrations.ADM', $request->ADM)
    ->get();    */


        $establishment = session()->get("establishment");

        if (env("APP_ENV", "local") == "local")
            $emp_megrations_query = emp_megration::join('employees', 'emp_megrations.MATRI', '=', 'employees.MATRI')
                ->where("employees.AFFECT", "390904");
        else
            $emp_megrations_query = emp_megration::join('employees', 'emp_megrations.MATRI', '=', 'employees.MATRI')
                ->where("employees.AFFECT", $establishment->estab_rawateb_user);

        //1pass
        //dd($emp_megrations_query);

        $emp_megrations = $emp_megrations_query
            ->where("emp_megrations.ADM", $request->ADM)
            ->Where("emp_megrations.ID_MEGRATION", $current_megration->ID_MEGRATION)
            ->select(
                'emp_megrations.*',
                'employees.*',
                'emp_megrations.ADM as ADM',
                'emp_megrations.SITFAM as SITFAM',
                'emp_megrations.CATEG as CATEG',
                'emp_megrations.ECH as ECH',
                'emp_megrations.AFFECT as AFFECT'
            )
            ->get();

        //2pass
        //dd($emp_megrations);

        //end  query
        //get adm record of seleted adm to affiche it in header of pdf
        $adm = adm::where("ADM", $request->ADM)->first();

        $view_data = [];
        /*item is an array has the info of any emp megration record with all grants of this records
          item is an array of key->value (item["key"]=$value)
          2 foreach (1 of emp_megration records infos /2 of all grants of any record) */
        //dd($emp_megrations);
        //if (isset($emp_megrations) && !empty($emp_megrations)) {

        foreach ($emp_megrations  as $key => $emp_megration) {
            /*  if ($key== 5)
                {dd($emp_megration);}; */
            //initialise item (empty item) in every foreach session
            $item = [];
            $item["matri"] = $emp_megration->MATRI;
            $item["fullName"] = $emp_megration->NOMA . ' ' . $emp_megration->PRENOMA;
            $item["SITFAM"] = $emp_megration->SITFAM;
            $item["CATEG"] = $emp_megration->CATEG;
            $item["ECH"] = $emp_megration->ECH;
            $item["CATEG"] = $emp_megration->CATEG;
            $item["NBRTRAV"] = $emp_megration->NBRTRAV;
            $item["SALBASE"] = $emp_megration->SALBASE;
            $item["TOTGAIN"] = $emp_megration->TOTGAIN;
            $item["BRUTSS"] = $emp_megration->BRUTSS;
            $item["RETSS"] = $emp_megration->RETSS;
            $item["ADM"] = $emp_megration->ADM;
            $item["AFFECT"] = $emp_megration->AFFECT;
            $item["RET"] = 0;

            foreach ($emp_megration->grants  as $grant) {
                switch ($grant->IND) {
                        // الاجر القاعدي
                    case "001":
                        $item["V001"] = $grant->MONTANT;
                        break;
                        // الاجر القاعدي
                    case "105":
                        $item["V105"] = $grant->MONTANT;
                        break;
                    case "280":
                        $item["V280"] = $grant->MONTANT;
                        break;
                    case "241":
                        $item["V241"] = $grant->MONTANT;
                        break;
                        // منحة المنطقة
                    case "225":
                        $item["V225"] = $grant->MONTANT;
                        break;
                        // منحة السكن
                    case "211":
                        $item["V211"] = $grant->MONTANT;
                        break;
                        // المنحة الجزافية
                    case "208":
                        $item["V208"] = $grant->MONTANT;
                        break;
                        // منحة المنصب
                    case "260":
                        $item["V260"] = $grant->MONTANT;
                        break;
                        // منحة التوثيق
                    case "290":
                        $item["V290"] = $grant->MONTANT;
                        break;
                        // منحة التأهيل
                    case "246":
                        $item["V246"] = $grant->MONTANT;
                        break;
                        // منحة الخبرة المهنية
                    case "101":
                        $item["V101"] = $grant->MONTANT;
                        break;
                        // المنحة  البداغوجية
                    case "103":
                        $item["V103"] = $grant->MONTANT;
                        break;
                        // المنح العائلية
                        /// الاجر الوحيد
                    case "401":
                        $item["V401"] = $grant->MONTANT;
                        break;
                        /// اكبر 10 سنوات
                    case "991":
                        $item["V991"] = $grant->MONTANT;
                        break;
                        /// المنحة العائلية
                    case "990":
                        $item["V990"] = $grant->MONTANT;
                        $item["RET"] += $grant->MONTANT;
                        break;
                        /// اقتطاع الضريبة
                    case "980":
                        $item["V980"] = $grant->MONTANT;
                        $item["RET"] += $grant->MONTANT;

                        break;
                        /// اقتطاع التعاضدية
                    case "660":
                        $item["V660"] = $grant->MONTANT;
                        $item["RET"] += $grant->MONTANT;

                        break;
                        /// اقتطاع شرائح
                    case "397":
                        $item["V397"] = $grant->MONTANT;
                        $item["RET"] += $grant->MONTANT;

                        break;
                        /// اقتطاع ديون استهلاكية
                    case "398":
                        $item["V398"] = $grant->MONTANT;
                        $item["RET"] += $grant->MONTANT;

                        break;
                        ///  اقتطاع الخدمات
                    case "399":
                        $item["V399"] = $grant->MONTANT;
                        $item["RET"] += $grant->MONTANT;

                        break;
                        ///  اقتطاع الغياب
                    case "301":
                        $item["V301"] = $grant->MONTANT;
                        $item["RET"] += $grant->MONTANT;
                        break;
                        ///  اقتطاع الاضراب
                    case "302":
                        $item["V302"] = $grant->MONTANT;
                        $item["RET"] += $grant->MONTANT;
                        break;
                        ///  اقتطاع المعارضة
                    case "303":
                        $item["V303"] = $grant->MONTANT;
                        $item["RET"] += $grant->MONTANT;
                        break;
                        ///  الصلفي المدفوع
                    case "999":
                        $item["V999"] = $grant->MONTANT;
                        break;
                    case "270":
                        $item["V270"] = $grant->MONTANT;
                        break;
                    case "273":
                        $item["V273"] = $grant->MONTANT;
                        break;
                }
            } //end 1 foreach


            array_push($view_data, $item);
        } //end 2 foreach



        /*used to set the value of a configuration option
        determines the maximum number of allowed steps for matching the regular expression.
        This can be useful in preventing certain types of regex-related performance issues.*/

        $mpdf = new CMPDF();
        $mpdf->initialize([
            //to make the oriantion of pdf file landscape
            'orientation' => 'L',
        ]);
        // dd($view_data);
        $mpdf->viewToPDF('salary/global/pdf-ar', ['data' => $view_data, "adm" => $adm, 'serv' => [], "current_megration" => $current_megration]);

        //can use these functions :
        // $mpdf->getObject()->pdf_version = '1.5';
        // $mpdf->getObject()->SetHeader('Chapter1|Situation|{PAGENO}');
        // $mpdf->getObject()->SetFooter('FOOTER  PP');
        $mpdf->outPut('I');
    }

    /*
    salary single global
    */
    public function salary_single_global_print(Request $request)
    {
        /*  $startTime = microtime(true); */

        $Collection_emp_megrations_to_print = new Collection();

        $establishment = session()->get("establishment");

        $emp_megrations_query = emp_megration::with(["fonction", "employee"]);
        if (env("APP_ENV", "local") == "local")
            $emp_megrations_query = emp_megration::join('employees', 'emp_megrations.MATRI', '=', 'employees.MATRI')
                ->where("employees.AFFECT", "390904");
        else
            $emp_megrations_query = emp_megration::join('employees', 'emp_megrations.MATRI', '=', 'employees.MATRI')
                ->where("employees.AFFECT", $establishment->estab_rawateb_user);

        $selected_emp_megrations =  $emp_megrations_query
            ->where("emp_megrations.ADM", $request->ADM)
            ->Where("emp_megrations.ID_MEGRATION", $request->ID_MEGRATION)
            ->select(
                'emp_megrations.*',
                'employees.*',
                'emp_megrations.ADM as ADM',
                'emp_megrations.AFFECT as AFFECT'
            )
            ->get();




        foreach ($selected_emp_megrations as $e) {

            //$startTime = microtime(true);
            //dd($e);
            $salary_single = $e;
            $salary_grants = $e->grants;



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
            $emp_megrations_to_print = ["salary_single" => $salary_single, 'salary_grants' => $emp_megrations];
            //dd( $emp_megrations_to_print);
            $Collection_emp_megrations_to_print->add($emp_megrations_to_print);
        }
        //dd($Collection_emp_megrations_to_print);

        /*   $endTime = microtime(true);
        $executionTime = (($endTime - $startTime) * 1000); // Convert to milliseconds
        dd('Execution Time: ' . $executionTime . ' ms'); */

        //using html

        //return view('salary/global/sg-ar-page', ['Collection_emp_megrations_to_print' => $Collection_emp_megrations_to_print]);

        //using cmpdf mehtod in helper

        //ini_set("pcre.backtrack_limit", "-1");
        $mpdf = new CMPDF();
        $mpdf->initialize();
        //if ($request->lang == "ar")
        $mpdf->viewToPDF('salary/global/pdf-sg-ar', ['Collection_emp_megrations_to_print' => $Collection_emp_megrations_to_print]);
        //else
        //   $mpdf->viewToPDF('salary/single/pdf-sg-fr',  $Collection_emp_megrations_to_print);
        // I means inline view of pdf

        $mpdf->outPut('I');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(employee $employee)
    {
        //
    }
}
