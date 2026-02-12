<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\adm;
use App\Helper\CMPDF;
use App\Models\employee;
use App\Models\establishment;
use App\Models\dir_absence_reservation;
use App\Models\dir_absence_reservation_employee;
use App\Models\absence_reservation_statistic;

use Illuminate\Http\Request;

class DirAdminAbsenceReservationController extends Controller
{
    
    public function index()
    {
        $absence_reservations =  dir_absence_reservation::orderBy("YEAR", "DESC")
            ->orderBy("MONTH", "DESC")
            ->paginate(10);
        // dd( $absence_reservations);
        $adms = adm::all();

        return view("admin.absence_reservation_dir.list", ["adms" => $adms, "absence_reservations" => $absence_reservations]);
    }

    public function create()
    {
        return view("admin.absence_reservation_dir.add");
    }


    public function store(Request $request)
    {
        $absence_reservation = dir_absence_reservation::create([
            "YEAR" => $request->YEAR,
            "MONTH" => $request->MONTH,
            "Type" => $request->Type,
            "STATUS" => $request->STATUS
        ]);
        return redirect()->route("dir-admin-absence");
    }

    public function status(Request $request)
    {
        $absence_reservation =   dir_absence_reservation::where("dir_absence_reservation_id", $request->id)->first();
        // dd(  $absence_reservation ,$request);
        $absence_reservation->STATUS = intval($request->status);
        $absence_reservation->save();
        return redirect()->route("dir-admin-absence");
    }


    public function destroy(Request $request)
    {
        //  dd($request);
        dir_absence_reservation::destroy($request->id);
        return redirect()->route("dir-admin-absence");
    }

    public function reservationList(Request $request)
    {
        $search = $request->input('search');
        $adms = adm::all();
        $adms_select = $request->adms_select;
        $select_adms = [];

        $dir_absence_reservation_id  = $request->dir_absence_reservation_id;

        /*  if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();

        else
            $establishment = session()->get("establishment"); */

        $absence_reservation = dir_absence_reservation::where("dir_absence_reservation_id", $dir_absence_reservation_id)->first();

        $absence_reservation_employees = dir_absence_reservation_employee::join("employees", "absence_reservation_employees.MATRI", "employees.MATRI")
            //select because the error of delete
            ->select(
                "dir_absence_reservation_employees.*",
                "employees.*",
                "dir_absence_reservation_employees.id as absence_id",
                "employees.id as employee_id"
            )
            ->where("dir_absence_reservation_id", $dir_absence_reservation_id)
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
        return view("admin.absence_reservation_dir.employees-list", [
            "select_adms" => $select_adms,
            "adms" => $adms,
            "search" => $search,
            "dir_absence_reservation_id" => $dir_absence_reservation_id,
            "absence_reservation_employees" => $absence_reservation_employees,
            "absence_reservation" =>   $absence_reservation
        ]);
    }

    public function absence_reservation_print(Request $request)
    {



        $current_absence_reservation = dir_absence_reservation::where('dir_absence_reservation_id', $request->dir_absence_reservation_id)->first();
        if ($current_absence_reservation  === null) {
            return redirect()->back();
        }



        $absence_reservation_employeess = dir_absence_reservation_employee::join('employees', 'absence_reservation_employees.MATRI', '=', 'employees.MATRI')
            ->Where("absence_reservation_employees.dir_absence_reservation_id", $current_absence_reservation->dir_absence_reservation_id)
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
        $mpdf->viewToPDF('admin/absence_reservation_dir/pdf-ar', ['absence_reservation_employeess' => $absence_reservation_employeess,  "current_absence_reservation" => $current_absence_reservation]);

        $mpdf->outPut('I');
    }

    public function absence_reservation_sql_export(Request $request)
    {


        $current_absence_reservation = dir_absence_reservation::where('dir_absence_reservation_id', $request->dir_absence_reservation_id)->first();
        if ($current_absence_reservation  === null) {
            return redirect()->back();
        }



        $absence_reservation_employeess = dir_absence_reservation_employee::join('employees', 'absence_reservation_employees.MATRI', '=', 'employees.MATRI')
            ->Where("absence_reservation_employees.dir_absence_reservation_id", $current_absence_reservation->dir_absence_reservation_id)
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


        return view("admin.absence_reservation_dir.export-excel", [
            "absence_reservation_employeess" => $absence_reservation_employeess,
            "ADM" => $request->ADM,
            "MONTH" => $current_absence_reservation->MONTH,
            "YEAR" => $current_absence_reservation->YEAR,

        ]);
    }
}
