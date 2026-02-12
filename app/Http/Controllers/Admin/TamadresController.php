<?php

namespace App\Http\Controllers\Admin;

use App\Models\adm;
use App\Helper\CMPDF;
use App\Models\employee;
use App\Models\megration;
use Illuminate\Http\Request;
use App\Models\ta_megration;
use App\Models\tamadres_megration;
use App\Http\Controllers\Controller;

class TamadresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        return view('admin/tamadres/employees-list', ["employees" => $employees, "adms" => $adms, "select_adms" => $select_adms, "select_sitpai" => $select_sitpai, "search" => $search]);
    }

    public function tamadres_single_list($MATRI)
    {
        //one record (first)
        $employee = employee::where("MATRI", $MATRI)->first();
        //all the records (get)
        $tamadres_singles = tamadres_megration::with("ta_megration")->where("MATRI", $MATRI)->get();
        //passing 2 variables (employee, tamadres_singles) with returning view salary/single/list
        return view('admin/tamadres/single/list', ["tamadres_singles" => $tamadres_singles, "employee" => $employee]);
    }

    public function tamadres_single_print(Request $request)
    {

        //dd($request);


        $tamadresDatas =  tamadres_megration::where("MATRI", $request->MATRI)
            ->where("ADM", $request->ADM)
            ->where("ID_MEGRATION_TA", $request->IDMEGR)
            //->where('NUMBERCHILD',"!=", null)
            //->where("AFFECT", $current_rw_id)
            //->orderBy('MATRI', 'ASC')
            ->first();

        //dd($rappel);

        if (!defined('_MPDF_TTFONTPATH')) {
            // an absolute path is preferred, trailing slash required:
            define('_MPDF_TTFONTPATH', realpath('theme/font'));
            // example using Laravel's resource_path function:
            //define('_MPDF_TTFONTPATH', public_path('theme/font'));
        }

        // Document Settings
        $settings =  [
            'mode'                     => '',
            'format'                   => 'A4',
            'default_font_size'        => '12',
            'default_font'             => 'sans-serif',
            'margin_left'              => 10,
            'margin_right'             => 10,
            'margin_top'               => 10,
            'margin_bottom'            => 10,
            'margin_header'            => 0,
            'margin_footer'            => 0,
            'orientation'              => 'P',
            'title'                    => 'PDF File',
            'subject'                  => '',
            'author'                   => '',
            'watermark'                => '',
            'show_watermark'           => false,
            'show_watermark_image'     => false,
            'watermark_font'           => 'sans-serif',
            'display_mode'             => 'fullpage',
            'watermark_text_alpha'     => 0.1,
            'watermark_image_path'     => '',
            'watermark_image_alpha'    => 0.2,
            'watermark_image_size'     => 'D',
            'watermark_image_position' => 'P',
            /*
        'custom_font_dir'          => _MPDF_TTFONTPATH,
        'custom_font_data'         => [
            'arial' => [
                'R'  => 'arial.ttf',
                'B'  => 'arialbd.ttf',
                'useOTL' => 0xFF,
                'useKashida' => 75,
            ],
            'janna' => [
                'R'  => 'Janna_LT_Regular.ttf',
                'B'  => 'Janna_LT_Bold.ttf',
                'useOTL' => 0xFF,
                'useKashida' => 75,
            ],
            'idcode39' => [
                'R'  => 'IDAutomationHC39M.ttf',
            ],
        ],
        */
            'auto_language_detection'  => false,
            'temp_dir'                 => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
            'pdfa'                     => false,
            'pdfaauto'                 => false,
            'use_active_forms'         => false,
        ];
        //dd($tamadresDatas);
        $mpdf = new CMPDF();
        $mpdf->initialize($settings);
        //dd($tamadresDatas);
        $mpdf->viewToPDF('admin/tamadres/single/pdf-tamadres', ["tamadresDatas" => $tamadresDatas, "serv" => []]);

        //can use these functions :
        // $mpdf->getObject()->pdf_version = '1.5';
        // $mpdf->getObject()->SetHeader('Chapter1|Situation|{PAGENO}');
        // $mpdf->getObject()->SetFooter('FOOTER  PP');
        $mpdf->outPut('I');
    }


    /*

global

*/
    public function tamadres_global_megration_list()
    {
        $ta_megrations = ta_megration::orderBy("YEAR", "DESC")->orderBy("TITLE", "DESC")->get();
        $adms = adm::all();
        //passing variable $megrations with returning view
        return view("admin/tamadres/global/ta_megration_list", ["ta_megrations" => $ta_megrations, "adms" => $adms]);
    }


    public function tamadres_global_print(Request $request)
    {
        /*   dd($request->ID_MEGRATION_TA);
        dd($request->ID_MEGRATION_TA);
        dd($request->ID_MEGRATION_TA);
 */
        $current_megration =  ta_megration::where('ID_MEGRATION_TA', $request->ID_MEGRATION_TA)->first();
        //dd($current_megration);
        if ($current_megration === null) {
            return redirect()->back();
        }
        //dd($current_megration);
        /*variable emp_megration_query has emp_megration  get records  with complicate query
        the query has aditonal condition if isset the adm select in view */
        //begin query
        $establishment = session()->get("establishment");

        if (env("APP_ENV", "local") == "local")
            $tamadres_megrations_query = tamadres_megration::join('employees', 'tamadres_megrations.MATRI', '=', 'employees.MATRI')
                ->where("employees.AFFECT", "390904");
        else
            $tamadres_megrations_query = tamadres_megration::join('employees', 'tamadres_megrations.MATRI', '=', 'employees.MATRI')
                ->where("employees.AFFECT", $establishment->estab_rawateb_user);

        //dd($tamadres_megrations_query);


        $tamadres_megrations = $tamadres_megrations_query
            ->where("tamadres_megrations.ADM", $request->ADM)
            ->Where("tamadres_megrations.ID_MEGRATION_TA", $current_megration->ID_MEGRATION_TA)
            ->select(
                'tamadres_megrations.*',
                'employees.*',
                'tamadres_megrations.ADM as ADM',
                'tamadres_megrations.AFFECT as AFFECT'
            )
            ->get();

        $adm = adm::where("ADM", $request->ADM)->first();

        $view_data = [];
        // dd($tamadres_megrations);
        foreach ($tamadres_megrations  as $tamadres_megration) {

            $item = [];
            $item["matri"] = $tamadres_megration->MATRI;
            $item["AFFECT"] = $tamadres_megration->AFFECT;
            $item["ADM"] = $tamadres_megration->ADM;
            $item["fullName"] = $tamadres_megration->NOMA . ' ' . $tamadres_megration->PRENOMA;
            $item["SITFAM"] = $tamadres_megration->SITFAM;
            $item["CATEG"] = $tamadres_megration->CATEG;
            $item["ECH"] = $tamadres_megration->ECH;
            $item["ENFSCO"] = $tamadres_megration->ENFSCO;
            $item["TAUXAF"] = $tamadres_megration->TAUXAF;
            $item["NETPAI"] = $tamadres_megration->NETPAI;


            /*    $item["JRPRIME"] = $tamadres_megration->JRPRIME;
            $item["SALBASE"] = $rend_megration->SALBASE;
            $item["IEPIND"] = $rend_megration->IEPIND;
            $item["TOTGAIN"] = $rend_megration->TOTGAIN;
            $item["RETSS"] = $rend_megration->RETSS;
            $item["RETITS"] = $rend_megration->RETITS;
            $item["MONTF"] = $rend_megration->MONTF;
            $item["NETPAI"] = $rend_megration->NETPAI;
 */
            $item["RET"] = 0;




            array_push($view_data, $item);
        }
        /*used to set the value of a configuration option
        determines the maximum number of allowed steps for matching the regular expression.
        This can be useful in preventing certain types of regex-related performance issues.*/

        $mpdf = new CMPDF();
        $mpdf->initialize([
            //to make the oriantion of pdf file landscape
            'orientation' => 'L',
        ]);
        // dd($view_data);
        // dd($view_data);
        $mpdf->viewToPDF('admin/tamadres/global/pdf-ar', ['data' => $view_data, "adm" => $adm, 'serv' => [], "current_megration" => $current_megration]);

        //can use these functions :
        // $mpdf->getObject()->pdf_version = '1.5';
        // $mpdf->getObject()->SetHeader('Chapter1|Situation|{PAGENO}');
        // $mpdf->getObject()->SetFooter('FOOTER  PP');
        $mpdf->outPut('I');


    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
