<?php

namespace App\Http\Controllers;

use App\Models\adm;
use App\Helper\CMPDF;
use App\Models\employee;
use Illuminate\Http\Request;
use App\Models\rap_rend_megration;
use App\Http\Controllers\Controller;

class RappelRendementController extends Controller
{
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

        // dd($employees->toSql());
        $employees =  $employees->paginate(12);
        // Append the search parameter to the pagination links
        /* it resolve the pbm that when i click the cursor of paginator return all employees
          without search conditions */
        $employees->appends(['search' => $search]);
        $statuss = [1, 2, 3, 4, 5];
        // returning view employees-list with passing parametre employees
        //dd($adms_select);
        return view('rappel_rendement/employees-list', [
            "employees" => $employees,
            "adms" => $adms,
            "select_adms" => $select_adms,
            "select_sitpai" => $select_sitpai,
            "search" => $search
        ]);
    }

    public function rappel_rendement_list($MATRI)

    {
        //one record (first)
        $employee = employee::where("MATRI", $MATRI)->first();
        //all the records (get)
        $raprend_singles = rap_rend_megration::with("ra_re_megration")
            ->where("MATRI", $MATRI)
            ->join('ra_re_megrations', 'rap_rend_megrations.ID_MEGRATION_RA_RE', '=', 'ra_re_megrations.ID_MEGRATION_RA_RE')
            ->orderBy('ra_re_megrations.YEAR', 'DESC')
            ->select('rap_rend_megrations.*') // Avoid duplicate columns from join
            ->paginate(10);
        //$rappel_singles = rappel_megration::with("ra_megration")->where("MATRI", "0000247")->get();
        //dd( $rappel_singles);
        //passing 2 variables (employee, salary_singles) with returning view salary/single/list
        return view('rappel_rendement/list', ["raprend_singles" => $raprend_singles, "employee" => $employee]);
    }

    public function rappel_rendement_print(Request $request)
    {
        //dd($request);

        $raprend = rap_rend_megration::where("MATRI", $request->MATRI)->where("SEQ", $request->SEQ)->where("ID_MEGRATION_RA_RE", $request->ID_MEGRATION_RA_RE)->first();
        //$rappel = rappel_megration::where("MATRI", "0000247")->where("SEQ", $request->SEQ)->where("ID_MEGRATION_RA", $request->ID_MEGRATION_RA)->first();

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

        $mpdf = new CMPDF();
        $mpdf->initialize($settings);
        //dd($raprend);
        $mpdf->viewToPDF('rappel_rendement/pdf-raprend', ["raprend" => $raprend, "serv" => []]);

        //can use these functions :
        // $mpdf->getObject()->pdf_version = '1.5';
        // $mpdf->getObject()->SetHeader('Chapter1|Situation|{PAGENO}');
        // $mpdf->getObject()->SetFooter('FOOTER  PP');
        $mpdf->outPut('I');
    }
}
