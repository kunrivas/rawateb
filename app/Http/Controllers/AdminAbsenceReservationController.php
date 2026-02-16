<?php

namespace App\Http\Controllers\Admin;

use App\Models\adm;
use App\Helper\CMPDF;
use App\Models\employee;
use Illuminate\Http\Request;
use App\Models\establishment;
use App\Models\absence_reservation;
use App\Http\Controllers\Controller;
use App\Models\absence_reservation_employee;
use App\Models\absence_reservation_statistic;

class AdminAbsenceReservationController extends Controller
{

    public function index()
    {
        $absence_reservations =  absence_reservation::orderBy("YEAR", "DESC")
            ->orderBy("MONTH", "DESC")
            ->paginate(10);
        // dd( $absence_reservations);
        $adms = adm::all();

        return view("admin.absence_reservation.list", ["adms" => $adms, "absence_reservations" => $absence_reservations]);
    }

    public function create()
    {
        return view("admin.absence_reservation.add");
    }


    public function store(Request $request)
    {
        $absence_reservation = absence_reservation::create([
            "YEAR" => $request->YEAR,
            "MONTH" => $request->MONTH,
            "Type" => $request->Type,
            "STATUS" => $request->STATUS
        ]);
        return redirect()->route("admin-absence");
    }


    /* public function establishmentList(Request $request)
    {
        $search = $request->input('search');

        $absence_reservation = absence_reservation::where("absence_reservation_id", $request->absence_reservation_id)->first();
        $absence_reservationsStatistics =  absence_reservation_statistic::with("establishment")->where("absence_reservation_id", $request->absence_reservation_id);
        if (isset($search) && !empty($search)) {


            $absence_reservationsStatistics =  absence_reservation_statistic::with(['establishment' => function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('estab_ar_name', 'like', '%' . $search . '%')
                        ->orWhere('estab_rawateb_user', 'like', '%' . $search . '%');
                });
            }])
                ->where("absence_reservation_id", $request->absence_reservation_id);


        }
        $absence_reservationsStatistics = $absence_reservationsStatistics->paginate(12);
        $statistic["total"] = establishment::whereIn("estab_type", ["ثانوية", "متوسطة"])->count();
        $statistic["start"] = absence_reservation_statistic::where("absence_reservation_id", $request->absence_reservation_id)->count();
        return   view("admin.absence_reservation.establishment-list", ["search" => $search, "absence_reservationsStatistics" => $absence_reservationsStatistics, "statistic" => $statistic, "absence_reservation" => $absence_reservation]);
    }

    public function in_establishmentList($absence_reservation_id, Request $request)
    {
        $search = $request->input('search');
        $establishments =  establishment::whereIn("estab_type", ["ثانوية", "متوسطة"])->whereNotIn("id", absence_reservation_statistic::select("establishment_id")->where("absence_reservation_id", $absence_reservation_id)->get());
        if (isset($search) && !empty($search)) {
            $establishments =    $establishments->where(function ($query) use ($search) {
                $query->where('estab_ar_name', 'like', '%' . $search . '%')
                    ->orWhere('estab_rawateb_user', 'like', '%' . $search . '%');
            });
        }   //to paginate it change ->get by ->paginate(12);
        $establishments = $establishments->paginate(12);
        return   view("admin.absence_reservation.in-establishment-list", ["absence_reservation_id" => $absence_reservation_id, "establishments" => $establishments, "search" => $search]);
    }

    public function reservationEstablishmentList(Request $request)
    {
        $rappelStatistic_id = $request->rappelStatistic_id;
        $absence_reservations_statistic = absence_reservation_statistic::with("establishment")->where("id", $rappelStatistic_id)->first();
        $establishment = establishment::where("id",  $absence_reservations_statistic->establishment_id)->first();

        $rappelReservation = absence_reservation::where("absence_reservation_id",  $absence_reservations_statistic->absence_reservation_id)->first();

        $absence_reservations_employees = absence_reservation_employee::with("employee")->where("absence_reservation_id", $rappelReservation->absence_reservation_id)->where("establishment_id", $establishment->id)->get();
        $absence_reservations_employees_types= $absence_reservations_employees->groupBy(function ($absence_reservation_employees) {
            return  $absence_reservation_employees->rappel_type;
        });

        return view("admin.absence_reservation.employee-list", ["absence_reservations_employees_types"=>$absence_reservations_employees_types,"absence_reservations_employees" => $absence_reservations_employees, "rappelReservation" => $rappelReservation, "absence_reservations_statistic" => $absence_reservations_statistic]);
    } */

    public function status(Request $request)
    {
        $absence_reservation =   absence_reservation::where("absence_reservation_id", $request->id)->first();
        // dd(  $absence_reservation ,$request);
        $absence_reservation->STATUS = intval($request->status);
        $absence_reservation->save();
        return redirect()->route("admin-absence");
    }


    public function destroy(Request $request)
    {
        //  dd($request);
        absence_reservation::destroy($request->id);
        return redirect()->route("admin-absence");
    }

    public function reservationList(Request $request)
    {
        $search = $request->input('search');
        $adms = adm::all();
        $adms_select = $request->adms_select;
        $select_adms = [];

        $absence_reservation_id  = $request->absence_reservation_id;

        /*  if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();

        else
            $establishment = session()->get("establishment"); */

        $absence_reservation = absence_reservation::where("absence_reservation_id", $absence_reservation_id)->first();

        $absence_reservation_employees = absence_reservation_employee::join("employees", "absence_reservation_employees.MATRI", "employees.MATRI")
            //select because the error of delete
            ->select(
                "absence_reservation_employees.*",
                "employees.*",
                "absence_reservation_employees.id as absence_id",
                "employees.id as employee_id"
            )
            ->where("absence_reservation_id", $absence_reservation_id)
            /*  ->where("AFFECT", $establishment->estab_rawateb_user) */;

        if (isset($search) && !empty($search)) {
            $absence_reservation_employees =    $absence_reservation_employees->whereHas("employee", function ($query) use ($search) {
                $query->where('NOMA', 'like', '%' . $search . '%')
                    ->orWhere('PRENOMA', 'like', '%' . $search . '%')
                    ->orWhere('MATRI', 'like', '%' . $search . '%');
            });
        }
        $select_adms = [];
        if ($request->has("adms")) {
            $select_adms =  array_keys($request->adms);
            $absence_reservation_employees =    $absence_reservation_employees->whereHas("employee", function ($query) use ($select_adms) {
                $query->whereIn("ADM",   $select_adms);
            });
        }
        $absence_reservation_employees  = $absence_reservation_employees
            ->orderBy("absence_reservation_employees.created_at", "DESC")
            ->GET();
        // dd( $absence_reservation_employees);
        return view("admin.absence_reservation.employees-list", [
            "select_adms" => $select_adms,
            "adms" => $adms,
            "search" => $search,
            "absence_reservation_id" => $absence_reservation_id,
            "absence_reservation_employees" => $absence_reservation_employees,
            "absence_reservation" =>   $absence_reservation
        ]);
    }

    public function absence_reservation_print(Request $request)
    {



        $current_absence_reservation = absence_reservation::where('absence_reservation_id', $request->absence_reservation_id)->first();
        if ($current_absence_reservation  === null) {
            return redirect()->back();
        }



        $absence_reservation_employeess = absence_reservation_employee::join('employees', 'absence_reservation_employees.MATRI', '=', 'employees.MATRI')
            ->Where("absence_reservation_employees.absence_reservation_id", $current_absence_reservation->absence_reservation_id)
            ->orderby("absence_reservation_employees.MATRI")
            ->get()
            ->groupBy(function ($absence_reservation_employees) {
                return  $absence_reservation_employees->employee->ADM;
            });

            ini_set('pcre.backtrack_limit', 5000000);
            ini_set('memory_limit', '256M');

        /*used to set the value of a configuration option
        determines the maximum number of allowed steps for matching the regular expression.
        This can be useful in preventing certain types of regex-related performance issues.*/

        $mpdf = new CMPDF();
        $mpdf->initialize([]);
        // dd($view_data);
        // dd($view_data);
        $mpdf->viewToPDF('admin/absence_reservation/pdf-ar', ['absence_reservation_employeess' => $absence_reservation_employeess,  "current_absence_reservation" => $current_absence_reservation]);

        $mpdf->outPut('I');
    }

    public function absence_reservation_sql_export(Request $request)
    {


        $current_absence_reservation = absence_reservation::where('absence_reservation_id', $request->absence_reservation_id)->first();
        if ($current_absence_reservation  === null) {
            return redirect()->back();
        }



        $absence_reservation_employeess = absence_reservation_employee::join('employees', 'absence_reservation_employees.MATRI', '=', 'employees.MATRI')
            ->Where("absence_reservation_employees.absence_reservation_id", $current_absence_reservation->absence_reservation_id)
            ->Where("employees.ADM", $request->ADM)
            ->get()->groupBy(function ($absence_reservation_employees) {
                return $absence_reservation_employees->MATRI;
            })->map(function ($group) {
                // Sum the NBR_DAYS for each group
                return [
                    'MATRI' => $group->first()->MATRI,
                    'PRENOMA' => $group->first()->PRENOMA ?? null,
                    'NOMA' => $group->first()->NOMA ?? null,
                    'DAY_FROM' => $group->first()->DAY_FROM ?? null,
                    'DAY_TO' => $group->first()->DAY_TO ?? null,
                    'NBR_DAYS' => $group->sum('NBR_DAYS') // Calculate the sum of NBR_DAYS
                ];
            });


        return view("admin.absence_reservation.export-excel", [
            "absence_reservation_employeess" => $absence_reservation_employeess,
            "ADM" => $request->ADM,
            "MONTH" => $current_absence_reservation->MONTH,
            "YEAR" => $current_absence_reservation->YEAR,

        ]);
    }
}
