<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\adm;
use App\Models\employee;
use App\Models\establishment;
use App\Models\RendementReservation;
use App\Models\RendementReservationEmployee;
use App\Models\RendementReservationsStatistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\XmlConfiguration\Group;
use App\Helper\CMPDF;

class RendementReservationController extends Controller
{
    /*
    function index()return all rendement trimestres rows order by year
     */
    public function index()
    {
        $rendemenReservations =  RendementReservation::orderBy("YEAR", "DESC")
            ->orderBy("TRIMESTRE", "DESC")
            ->paginate(10);
        return view("rendement_reservation.list", ["rendemenReservations" => $rendemenReservations]);
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




        $rendement_reservations_employees = RendementReservationEmployee::with("employee")->where("rendement_reservations_id", $rendement_reservations_id)->where("affect", $establishment->estab_rawateb_user);
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

        return view("rendement_reservation.employee-list", ["select_adms" => $select_adms, "adms" => $adms, "search" => $search, "rendement_reservations_employees" => $rendement_reservations_employees, "rendementReservation" => $rendementReservation]);
    }

    /* the function pre_process initialize the row of RendementReservationsStatistics in the first time
     and inistialize all the rows of RendementReservationEmployees (add all matri of employees of establishement )*/
    private function pre_process($rendementReservation, $establishment)
    {
        //get all worked employees (status =1) of my establishement
        $employees = employee::where("AFFECT",  $establishment->estab_rawateb_user)->where("SITPAI", "0")->get();
        //initialize the row of RendementReservationsStatistics
        $rendement_reservations_statistic = RendementReservationsStatistic::create(["reserved" => 0, "total" =>    $employees->count(), "establishment_id" => $establishment->id, "rendement_reservations_id" => $rendementReservation->id, "ziroPoint" => 0]);
        //initialize the rows of RendementReservationsemployees
        $r_r_employees = $employees->map(function ($emp) use ($rendementReservation, $establishment) {
            $r_r_emp = new RendementReservationEmployee();
            $r_r_emp->MATRI = $emp->MATRI;
            $r_r_emp->abs = $rendementReservation->absTotal - $emp->workCount($rendementReservation);
            $r_r_emp->point = null;
            $r_r_emp->affect = $establishment->estab_rawateb_user;
            $r_r_emp->rendement_reservations_id = $rendementReservation->id;
            return $r_r_emp->toArray(); // Convert model to array
        });
        RendementReservationEmployee::insert($r_r_employees->all());
        return true;
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
        $rendement_reservations_employees = RendementReservationEmployee::with("employee")->where("rendement_reservations_id", $rendement_reservations_id)->where("affect", $establishment->estab_rawateb_user);
        $rendement_reservations_adms =  $rendement_reservations_employees->get()->groupBy(function ($rendement_reservation) {
            return  $rendement_reservation->employee->ADM;
        });
        $mpdf = new CMPDF();
        // $mpdf->initialize(['default_font'=>'Arial','custom_font_dir'=>asset('/Admin3/dist/fonts/')]);
        $mpdf->initialize();

        $mpdf->viewToPDF('rendement_reservation/pdf-init',    ["rendementReservation" => $rendementReservation, "rendement_reservations_adms" => $rendement_reservations_adms, "establishment" => $establishment]);

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
        $rendement_reservations_employees = RendementReservationEmployee::with("employee")->where("rendement_reservations_id", $rendement_reservations_id)->where("affect", $establishment->estab_rawateb_user);
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

        $mpdf->viewToPDF('rendement_reservation/pdf-final',    ["rendementReservation" => $rendementReservation, "rendement_reservations_adms" => $rendement_reservations_adms, "rendement_reservations_statistic" => $rendement_reservations_statistic, "establishment" => $establishment]);

        // I means inline view of pdf
        $mpdf->outPut('I');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function saveAll(Request $request)
    {
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");
        DB::transaction(function () use ($request, $establishment) {
            $kyes = array_keys($request->employees);
            $rendement_reservations_employees =  RendementReservationEmployee::with("employee")
                ->whereIn("MATRI", $kyes)
                ->where("rendement_reservations_id", $request->rendement_reservations_id)->get();

            //boucle to parcourir all the request employes
            $rendement_reservations_employees->each(
                function (RendementReservationEmployee $rw) use ($request) {
                    // verify if TAUXPT < request point to show message error
                    if (
                        $rw->employee->fonction != null
                        && $rw->employee->fonction->TAUXPR  < $request->employees[$rw->MATRI]["point"]
                    ) {
                        $message = "نقطة الموظف "  . $rw->employee->PRENOMA . " " . $rw->employee->NOMA . " (" . $rw->MATRI .  ") ليست صحيحة";
                        return redirect()->back()->with("message", $message);
                    }
                    //save the point
                    $rw->point = $request->employees[$rw->MATRI]["point"];
                    $rw->save();
                }
            );
            // remplir table statistic by count table RendementReservationEmployee with conditions
            $statistic = RendementReservationsStatistic::where("establishment_id", $establishment->id)->where("rendement_reservations_id", $request->rendement_reservations_id)->first();
            //where not null point
            $statistic->reserved = RendementReservationEmployee::where("affect", $establishment->estab_rawateb_user)->where("rendement_reservations_id", $request->rendement_reservations_id)->whereNotNull("point")->count();
            //where point = 0
            $statistic->ziroPoint = RendementReservationEmployee::where("affect", $establishment->estab_rawateb_user)->where("rendement_reservations_id", $request->rendement_reservations_id)->whereNotNull("point")->where("point", 0)->count();
            $statistic->total = RendementReservationEmployee::where("affect", $establishment->estab_rawateb_user)->where("rendement_reservations_id", $request->rendement_reservations_id)->count();
            $statistic->save();
        });
        return redirect()->back(); //("message","تم العملية بنجاح");
    }
    /**
     * Display the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function addEmployeeList(Request $request)
    {
        $rendement_reservations_id = $request->rendement_reservations_id;
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();



        else
            $establishment = session()->get("establishment");
        $rendementReservation = RendementReservation::where("id", $rendement_reservations_id)->first();
        $employees = employee::where("AFFECT", $establishment->estab_rawateb_user)->whereNotIn("MATRI", RendementReservationEmployee::select("MATRI")->where("rendement_reservations_id", $rendement_reservations_id)->where("affect", $establishment->estab_rawateb_user)->get())->get();
        return view("rendement_reservation.add-employee-list", ["employees" => $employees, "rendementReservation" => $rendementReservation]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function addEmployee(Request $request)
    {
        $rendement_reservations_id = $request->rendement_reservations_id;
        $MATRI = $request->MATRI;
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();

        else
            $establishment = session()->get("establishment");
        $rendementReservation = RendementReservation::where("id", $rendement_reservations_id)->first();
        $r_r_employee =  RendementReservationEmployee::where("MATRI", $MATRI)->where("rendement_reservations_id", $rendement_reservations_id)->first();
        if ($r_r_employee) {
            $r_r_employee->affect =  $establishment->estab_rawateb_user;
            $r_r_employee->save();
        } else {
            $emp = employee::where("MATRI", $MATRI)->first();
            $r_r_emp = new RendementReservationEmployee();
            $r_r_emp->MATRI = $emp->MATRI;
            $r_r_emp->abs = $rendementReservation->absTotal - $emp->workCount($rendementReservation);
            $r_r_emp->point = null;
            $r_r_emp->affect = $establishment->estab_rawateb_user;
            $r_r_emp->rendement_reservations_id = $rendementReservation->id;
            $r_r_emp->save();
        }
        return redirect()->route("rendements-reservation-employee-list", $rendementReservation->id);
    }


    public function delete(Request $request)
    {
        $rendement_reservations_id = $request->rendement_reservations_id;
        $MATRI = $request->MATRI;
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();

        else
            $establishment = session()->get("establishment");
        RendementReservationEmployee::where("MATRI", $MATRI)
            ->where("rendement_reservations_id", $rendement_reservations_id)
            ->delete();


        return redirect()->route("rendements-reservation-employee-list", $rendement_reservations_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        RendementReservation::destroy($request->id);
        return redirect()->route("admin-rendements");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        $rendemenReservation =  RendementReservation::find($request->id);
        //  dd(intval($request->sitpai));
        $rendemenReservation->status = intval($request->status);
        $rendemenReservation->save();
        return redirect()->route("admin-rendements");
    }
}
