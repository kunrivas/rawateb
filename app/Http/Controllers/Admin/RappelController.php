<?php

////////*********//////
namespace App\Http\Controllers\Admin;

use App\Helper\CMPDF;
use App\Http\Controllers\Controller;
use App\Models\adm;
use App\Models\employee;
use App\Models\rappel_megration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RappelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { // dd( array_keys($request->sitpai));
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
        return view('admin/rappel/employees-list', ["employees" => $employees, "adms" => $adms, "select_adms" => $select_adms, "select_sitpai" => $select_sitpai, "search" => $search]);
    }



    public function rappel_list($MATRI)

    {
        //one record (first)
        $employee = employee::where("MATRI", $MATRI)->first();
        //all the records (get)
        $rappel_singles = rappel_megration::with("ra_megration")
            ->where("MATRI", $MATRI)
            ->join('ra_megrations', 'rappel_megrations.ID_MEGRATION_RA', '=', 'ra_megrations.ID_MEGRATION_RA')
            ->orderBy('ra_megrations.YEAR', 'DESC')
            ->select('rappel_megrations.*') // Avoid duplicate columns from join
            ->paginate(10);


        //$rappel_singles = rappel_megration::with("ra_megration")->where("MATRI", "0000247")->get();
        //dd( $rappel_singles);
        //passing 2 variables (employee, salary_singles) with returning view salary/single/list
        return view('admin/rappel/list', ["rappel_singles" => $rappel_singles, "employee" => $employee]);
    }


    public function rappel_print(Request $request)
    { //dd($request->all());

        $rappel = rappel_megration::with([

            'employee',

            'ra_megration:ID_MEGRATION_RA,TITLE,YEAR,LOT',

            // 🔥 NEW RASIT
            'new_rappel_rasit' => function ($q) use ($request) {
                $q->select('ID', 'MATRI', 'SEQ', 'ID_MEGRATION_RA', 'ADM', 'CATEG', 'ECH', 'SITFAM', 'CODEFONC')
                    ->where("OLDNEW", "N")
                    ->where("SEQ", $request->SEQ)
                    ->where("ID_MEGRATION_RA", $request->ID_MEGRATION_RA)
                    /* ->where("ADM", $request->ADM)*/;
            },

            'new_rappel_rasit.fonction:CODEFONC,LIBTABA',

            // 🔥 OLD RASIT
            'old_rappel_rasit' => function ($q) use ($request) {
                $q->select('ID', 'MATRI', 'SEQ', 'ID_MEGRATION_RA', 'ADM', 'CATEG', 'ECH', 'SITFAM', 'CODEFONC')
                    ->where("OLDNEW", "A")
                    ->where("SEQ", $request->SEQ)
                    ->where("ID_MEGRATION_RA", $request->ID_MEGRATION_RA)
                    /* ->where("ADM", $request->ADM) */;
            },

            'old_rappel_rasit.fonction:CODEFONC,LIBTABA',
        ])
            ->where("MATRI", $request->MATRI)
            ->where("SEQ", $request->SEQ)
            ->where("ID_MEGRATION_RA", $request->ID_MEGRATION_RA)
            ->firstOrFail();

        $grants = DB::table('rappel_grants as rg')

            // 🔵 OLD
            ->leftJoin('rappel_grants as old', function ($join) {
                $join->on('old.MATRI', '=', 'rg.MATRI')
                    ->on('old.SEQ', '=', 'rg.SEQ')
                    ->on('old.ID_MEGRATION_RA', '=', 'rg.ID_MEGRATION_RA')
                    ->on('old.IND', '=', 'rg.IND')
                    ->where('old.OLDNEW', 'A');
            })

            // 🟣 DUE
            ->leftJoin('rappel_grant_dues as due', function ($join) {
                $join->on('due.MATRI', '=', 'rg.MATRI')
                    ->on('due.SEQ', '=', 'rg.SEQ')
                    ->on('due.ID_MEGRATION_RA', '=', 'rg.ID_MEGRATION_RA')
                    ->on('due.IND', '=', 'rg.IND');
            })

            // 🟢 GRANT INFO (🔥 الجديد)
            ->leftJoin('grant_infos as gi', 'gi.IND', '=', 'rg.IND')

            ->select(
                'rg.MATRI',
                'rg.SEQ',
                'rg.ID_MEGRATION_RA',
                'rg.ADM',
                'rg.IND',
                'rg.MONTANT',
                'rg.BASENBR',

                // 🔥 LIBINDA
                'gi.LIBINDA',

                'old.MONTANT as old_montant',
                'old.BASENBR as old_basenbr',

                'due.MONTANT as due_montant',
                'due.BASENBR as due_basenbr'
            )

            ->where('rg.OLDNEW', 'N')
            ->where('rg.MATRI', $request->MATRI)
            ->where('rg.SEQ', $request->SEQ)
            ->where('rg.ID_MEGRATION_RA', $request->ID_MEGRATION_RA)

            ->when($request->ADM, function ($q) use ($request) {
                $q->where('rg.ADM', $request->ADM);
            })

            ->orderBy('rg.IND', 'ASC')
            ->get();

        // dd($rappel);

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
        $mpdf->viewToPDF('admin/rappel/pdf-rappel', ["rappel" => $rappel, "grants" => $grants, "serv" => []]);

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
