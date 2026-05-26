<?php

namespace App\Http\Controllers\Director;

use App\Http\Controllers\Controller;
use App\Models\adm;
use App\Models\employee;
use App\Models\establishment;
use App\Models\RendementReservation;
use App\Models\RendementReservationEmployee;
use App\Models\RendementReservationsStatistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // ← ضيف هذا السطر
use PHPUnit\TextUI\XmlConfiguration\Group;
use App\Helper\CMPDF;

class RendementReservationController extends Controller
{

    public $key_number = [
        10 => "A",
        11 =>  "B",
        12  => "C",
        13 => "D",
        14 => "E",
        15 => "F",
        16 => "G",
        17 => "H",
        18 => "i",
        19 => "J",
        20 => "K",
        21 => "L",
        22 =>  "M",
        23  => "N",
        24 => "O",
        25 =>   "P",
        26 => "Q",
        27 => "R",
        28 => "S",
        29 => "T",
        30 =>  "U",
    ];
    /*
    function index()return all rendement trimestres rows order by year
     */
    public function index()
    {
        $rendemenReservations =  RendementReservation::orderBy("YEAR", "DESC")
            ->orderBy("TRIMESTRE", "DESC")->paginate(10);
        return view("director.rendement_reservation.list", ["rendemenReservations" => $rendemenReservations]);
    }
    /*
    function reservationList() when click btn"معاينة" to affich the employees list and the statistics cards
    */
    public function reservationList(Request $request)
    {
        /* get request search and filtrage parametres  from employees-list blade */
        $search = $request->input('search');
        $adms_select = $request->adms_select;

        $adms = adm::all();
        $select_adms = [];

        /*  get establishement  */
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");

        // to get the  row of shosen trimestre  in table RendementReservations
        $rendement_reservations_id = $request->rendement_reservations_id;
        $rendementReservation = RendementReservation::where("id", $rendement_reservations_id)->first();

        //STATISTICS
        // to get the  row of shosen trimestre and my establishement  in table RendementReservationsSTATISCTICS
        $rendement_reservations_statistic = RendementReservationsStatistic::where("establishment_id", $establishment->id)
            ->where("rendement_reservations_id", $rendement_reservations_id)->first();
        /*  if the row doesnt exisst initialize this row and the rows of
        reservation_employees
        by function pre_process */
        if ($rendement_reservations_statistic == null)
            $rendement_reservations_statistic = $this->pre_process($rendementReservation, $establishment);


        // to get the all the   rows of  table rendement_reservation_employees with search and filtrage
        $rendement_reservations_employees = RendementReservationEmployee::with("employee")->where("rendement_reservations_id", $rendement_reservations_id)->where("estab_mail_code", $establishment->estab_mail_code);
        if (isset($search) && !empty($search)) {
            $rendement_reservations_employees =    $rendement_reservations_employees->whereHas("employee", function ($query) use ($search) {
                $query->where('NOMA', 'like', '%' . $search . '%')
                    ->orWhere('PRENOMA', 'like', '%' . $search . '%')
                    ->orWhere('MATRI', 'like', '%' . $search . '%');
            });
        }
        $select_adms = [];
        if ($request->has("adms")) {
            $select_adms =  array_keys($request->adms);
            $rendement_reservations_employees =    $rendement_reservations_employees->whereHas("employee", function ($query) use ($select_adms) {
                $query->whereIn("ADM",   $select_adms);
            });
        }

        $rendement_reservations_employees  = $rendement_reservations_employees->get();

        return view("director.rendement_reservation.employee-list", ["select_adms" => $select_adms, "adms" => $adms, "search" => $search, "rendement_reservations_employees" => $rendement_reservations_employees, "rendementReservation" => $rendementReservation, "rendement_reservations_statistic" => $rendement_reservations_statistic]);
    }

    /* the function pre_process initialize the row of RendementReservationsStatistics in the first time
     and inistialize all the rows of RendementReservationEmployees (add all matri of employees of establishement )*/
    private function pre_process($rendementReservation, $establishment)
    {
        return  RendementReservationsStatistic::create(["reserved" => 0, "total" =>  0, "establishment_id" => $establishment->id, "rendement_reservations_id" => $rendementReservation->id, "ziroPoint" => 0]);;
    }

    // print rendement initial
    public function print_init(Request $request)
    {

        $rendement_reservations_id = $request->rendement_reservations_id;
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");
        $rendementReservation = RendementReservation::where("id", $rendement_reservations_id)->first();

        $rendement_reservations_statistic = RendementReservationsStatistic::where("establishment_id", $establishment->id)->where("rendement_reservations_id", $rendement_reservations_id)->first();
        if ($rendement_reservations_statistic == null)
            $this->pre_process($rendementReservation, $establishment);
        $rendement_reservations_employees = RendementReservationEmployee::with("employee")->where("rendement_reservations_id", $rendement_reservations_id)->where("estab_mail_code", $establishment->estab_mail_code);
        $rendement_reservations_adms =  $rendement_reservations_employees->get()->groupBy(function ($rendement_reservation) {
            return  $rendement_reservation->employee->ADM;
        });
        $mpdf = new CMPDF();
        // $mpdf->initialize(['default_font'=>'Arial','custom_font_dir'=>asset('/Admin3/dist/fonts/')]);
        $mpdf->initialize();

        $mpdf->viewToPDF('director/rendement_reservation/pdf-init',    ["rendementReservation" => $rendementReservation, "rendement_reservations_adms" => $rendement_reservations_adms, "establishment" => $establishment]);

        // I means inline view of pdf
        $mpdf->outPut('I');
    }

    //print rendement final
    public function print_final(Request $request)
    {
        $rendement_reservations_id = $request->rendement_reservations_id;
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");
        $rendementReservation = RendementReservation::where("id", $rendement_reservations_id)->first();

        $rendement_reservations_statistic = RendementReservationsStatistic::where("establishment_id", $establishment->id)->where("rendement_reservations_id", $rendement_reservations_id)->first();
        if ($rendement_reservations_statistic == null)
            $this->pre_process($rendementReservation, $establishment);
        $rendement_reservations_employees = RendementReservationEmployee::with("employee")->where("rendement_reservations_id", $rendement_reservations_id)->where("estab_mail_code", $establishment->estab_mail_code);
        $rendement_reservations_adms =  $rendement_reservations_employees->get()->groupBy(function ($rendement_reservation) {
            return  $rendement_reservation->employee->ADM;
        });
        $mpdf = new CMPDF();
        $rendement_reservations_statistic->status = 1;
        $rendement_reservations_statistic->save();

        /*
            adding water mark
        */

        $mpdf->initialize([
            'watermark'                => '** مديرية التربية لولاية الوادي ** ',
            'show_watermark'           => true,
            'show_watermark_image'     => false
        ]);

        $mpdf->viewToPDF('director/rendement_reservation/pdf-final',    ["rendementReservation" => $rendementReservation, "rendement_reservations_adms" => $rendement_reservations_adms, "rendement_reservations_statistic" => $rendement_reservations_statistic, "establishment" => $establishment]);

        // I means inline view of pdf
        $mpdf->outPut('I');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param
     * @return \Illuminate\Http\Response
     */


    public function saveNew(Request $request)
    {    try {
        // your code here...
    
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");
        $rendementReservation = RendementReservation::where("id", $request->rendement_reservations_id)->first();
        if (!$rendementReservation) {
            return ["status" => 0, "message" => "الحجز غير موجود"];
        }
        $rendement_reservations_employee =  RendementReservationEmployee::with(["employee", "establishment"])
            ->where("MATRI",  $request->MATRI)
            ->where("estab_mail_code",  $establishment->estab_mail_code)
            ->where("rendement_reservations_id", $request->rendement_reservations_id)->first();
        if ($rendement_reservations_employee) {
            $message = " تم حجز هذا الموضف مسبقا في مؤسسة :  " . $rendement_reservations_employee->establishment->estab_ar_name ?? "";
            return ["status" => 0, "message" => $message];
        }

        $employee =  employee::where("MATRI", $request->MATRI)->first();
        if (!$employee) {
            return ["status" => 0, "message" => "الموظف غير موجود"];
        }

        if ($request->point === null || $request->point === '' || !is_numeric($request->point)) {
            return ["status" => 0, "message" => "يجب إدخال النقطة"];
        }

        if ($employee->fonction) {
            if ($request->point > $employee->fonction->TAUXPR) {
                $message = "نقطة الموظف "  . $employee->PRENOMA . " " . $employee->NOMA . " (" . $request->MATRI .  ") ليست صحيحة";
                return ["status" => 0, "message" => $message];
            }
        }

        if ((float) $request->point == 0 && trim((string) $request->zero_point_reason) === '') {
            return ["status" => 0, "message" => "يجب إدخال سبب منح نقطة 0"];
        }

        $r_r_emp = new RendementReservationEmployee();
        $r_r_emp->MATRI = $employee->MATRI;
        $r_r_emp->abs = $rendementReservation->absTotal - $employee->workCount($rendementReservation);
        $r_r_emp->point = $request->point;
        $r_r_emp->zero_point_reason = (float) $request->point == 0 ? trim((string) $request->zero_point_reason) : null;
        $r_r_emp->affect = $employee->AFFECT;
        $r_r_emp->estab_mail_code = $establishment->estab_mail_code;
        $r_r_emp->rendement_reservations_id = $rendementReservation->id;
        $r_r_emp->save();
        // remplir table statistic by count table RendementReservationEmployee with conditions
        $statistic = RendementReservationsStatistic::where("establishment_id", $establishment->id)->where("rendement_reservations_id", $request->rendement_reservations_id)->first();
        //where not null point
        $statistic->reserved = RendementReservationEmployee::where("estab_mail_code", $establishment->estab_mail_code)->where("rendement_reservations_id", $request->rendement_reservations_id)->whereNotNull("point")->count();
        //where point = 0
        $statistic->ziroPoint = RendementReservationEmployee::where("estab_mail_code", $establishment->estab_mail_code)->where("rendement_reservations_id", $request->rendement_reservations_id)->whereNotNull("point")->where("point", 0)->count();
        $statistic->total = RendementReservationEmployee::where("estab_mail_code", $establishment->estab_mail_code)->where("rendement_reservations_id", $request->rendement_reservations_id)->count();
        $statistic->save();
        return ["status" => 1];
        } catch (\Throwable $e) {
        return response()->json([
            "status" => 0,
            "message" => $e->getMessage()
        ]);
    }
    }




    public function delete(Request $request)
    {   //for statistics
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");

        //the delete
        $rendement_reservations_id = $request->rendement_reservations_id;
        $MATRI = $request->MATRI;
        RendementReservationEmployee::where("MATRI", $MATRI)
            ->where("rendement_reservations_id", $rendement_reservations_id)
            ->delete();

        //for statistics
        // remplir table statistic by count table RendementReservationEmployee with conditions
        $statistic = RendementReservationsStatistic::where("establishment_id", $establishment->id)->where("rendement_reservations_id", $request->rendement_reservations_id)->first();
        //where not null point
        $statistic->reserved = RendementReservationEmployee::where("estab_mail_code", $establishment->estab_mail_code)->where("rendement_reservations_id", $request->rendement_reservations_id)->whereNotNull("point")->count();
        //where point = 0
        $statistic->ziroPoint = RendementReservationEmployee::where("estab_mail_code", $establishment->estab_mail_code)->where("rendement_reservations_id", $request->rendement_reservations_id)->whereNotNull("point")->where("point", 0)->count();
        $statistic->total = RendementReservationEmployee::where("estab_mail_code", $establishment->estab_mail_code)->where("rendement_reservations_id", $request->rendement_reservations_id)->count();
        $statistic->save();

        return redirect()->back();
    }

    
    public function getEmployee($rendement_reservations_id, $MATRI)
    {

        $rendementReservation = RendementReservation::where("id", $rendement_reservations_id)->first();

        $employee = employee::with(["establishment", "fonction"]);
        $employee = $employee->where(function ($q) use ($MATRI) {

            if (array_key_exists(substr($MATRI, 0, 2), $this->key_number)) {
                $search = $this->key_number[substr($MATRI, 0, 2)] . substr($MATRI, 2);
                $q->orWhere("MATRI", "like", "%" . $search  . "%");
            }
            $q->orWhere("MATRI", "like", "%" . $MATRI . "%");
        });



        // ->where("MATRI", $MATRI)
        $employee = $employee->first();
        $employee->abs = $rendementReservation->absTotal - $employee->workCount($rendementReservation);
        //dd($employee);

        // Check if employee exists
        if (!$employee) {
            return response()->json(['error' => 'employee not found'], 404);
        }

        // Return employee data as JSON response
        return response()->json($employee);
    }
}
