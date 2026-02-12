<?php

namespace App\Http\Controllers\Absence;

use App\Models\adm;
use App\Helper\CMPDF;
use App\Models\employee;
use Illuminate\Http\Request;
use App\Models\establishment;
use App\Models\absence_reservation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\RappelReservationsStatistic;
use App\Models\absence_reservation_employee;
use App\Models\absence_reservation_statistic;

class AbsenceReservationController extends Controller
{
    //////////////////////reservation functions////////////////////////////////////////////

    public function index()
    {
        $absence_reservations =  absence_reservation::orderBy("YEAR", "DESC")
            ->orderBy("MONTH", "DESC")
            ->paginate(10);
        return view("absence.reservation.list", ["absence_reservations" => $absence_reservations]);
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
            ->paginate(8);

        $absence_reservation_employees->appends(['search' => $search]);

        // dd( $absence_reservation_employees);
        return view("absence.reservation.employees-list", [
            "select_adms" => $select_adms,
            "adms" => $adms,
            "search" => $search,
            "absence_reservation_id" => $absence_reservation_id,
            "absence_reservation_employees" => $absence_reservation_employees,
            "absence_reservation" =>   $absence_reservation
        ]);
    }

    public function getEmployee($MATRI)
    {
        /*  if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");
        // Fetch establishment data based on the ID
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");*/

        $employee = employee::with(["establishment", "fonction"])
            ->where("MATRI", $MATRI)
            ->where("SITPAI",0)
            //->where("AFFECT", $establishment->estab_rawateb_user)
            ->first();

        //dd($employee);

         // Check if employee exists
        if (!$employee) {
            return response()->json(['error' => 'الموظف غير موجود'], 404);
        }
         // Check if employee'يs SITPAI is not 0
         if ($employee->SITPAI != 0) {
            return response()->json(['error' => 'الموظف لايتقاضى الأجر حاليا'], 404);
        }

        // Return employee data as JSON response
        return response()->json($employee);
    }

    public function insertAbsence(Request $request)
    {
        // Validate the entire array of absences
        $validator = Validator::make($request->all(), [
            'absences' => 'required|array|min:1', // Ensure the absences array is present and has at least one item
            'absences.*.MATRI' => 'required|string', // MATRI (employee ID) is required for each absence
            'absences.*.atype' => 'required|integer', // Absence type is required for each absence
            'absences.*.adayfrom' => 'required|date', // Start date is required for each absence
            'absences.*.adayto' => 'required|date', // End date is required for each absence
            'absences.*.anbrdays' => 'required|integer|min:1', // Number of days is required for each absence
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $numAbsEroor = 1;
        // Loop through each absence in the absences array
        foreach ($request->input('absences') as $absence) {
            $start_abs = $absence['adayfrom'];
            $end_abs = $absence['adayto'];
            $MATRI = $absence['MATRI'];
            $atype = $absence['atype'];
            $anbrdays = $absence['anbrdays'];
            $areservationId = $absence['areservationId'];

            // Check if the absence period overlaps with any existing absence records for the same employee
            $res = absence_reservation_employee::where("MATRI", $MATRI)
                ->where(function ($q) use ($start_abs, $end_abs) {
                    $q->whereBetween("DAY_FROM", [$start_abs, $end_abs])
                        ->orWhereBetween("DAY_TO", [$start_abs, $end_abs])
                        ->orWhere(function ($q2) use ($start_abs, $end_abs) {
                            $q2->where("DAY_FROM", "<", $start_abs)
                                ->where("DAY_TO", ">", $end_abs);
                        });
                })->get();

            if ($res->count() > 0) {
                return response()->json(['status' => 'deplicated', 'numAbsEroor' => $numAbsEroor, 'data1' => $start_abs, 'data2' => $end_abs]); // Conflict with existing records
            }

            // Calculate total days taken so far for the employee in the given absence reservation
            $month = absence_reservation::where("absence_reservation_id", $areservationId)->first();
            $existing_days = absence_reservation_employee::where("absence_reservation_id", $areservationId)
                ->where("MATRI", $MATRI)
                ->sum("NBR_DAYS");

            if (($existing_days + $anbrdays) > 30) {
                return response()->json(['status' => 'plus', 'numAbsEroor' => $numAbsEroor, 'data1' => $start_abs, 'data2' => $end_abs, 'data' => ($existing_days + $anbrdays)]);
                //  return response()->json(['status' => 'plus', 'data' => ($existing_days + $anbrdays)], 400); // More than 30 days
            }

            // Check if the reservation is closed
            if ($month && $month->STATUS == 0) {
                return response()->json(['status' => 'end'], 400); // Reservation is closed
            }

            // Insert the absence record into the database
            $absence = absence_reservation_employee::create([
                'MATRI' => $MATRI,
                'absence_reservation_id' => $areservationId,
                'ABSENCE_TYPE' => $atype,
                'NBR_DAYS' => $anbrdays,
                'DAY_FROM' => $start_abs,
                'DAY_TO' => $end_abs,
                'ACTIVE' => 1,
            ]);

            $numAbsEroor++;
        }

        // Return success response
        return response()->json(['status' => 'add', 'message' => 'Absences added successfully']);
    }


    public function destroy($id)
    { //dd($id);
        $absence_reservation_employee = absence_reservation_employee::findOrFail($id);
        $absence_reservation_employee->delete();
        return redirect()->back();
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


        ini_set('pcre.backtrack_limit', 10000000);
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 300); // 300 ثانية = 5 دقائق
        /*used to set the value of a configuration option
        determines the maximum number of allowed steps for matching the regular expression.
        This can be useful in preventing certain types of regex-related performance issues.*/

        $mpdf = new CMPDF();
        $mpdf->initialize([]);
        // dd($view_data);
        // dd($view_data);
        $mpdf->viewToPDF('absence/reservation/pdf-ar', ['absence_reservation_employeess' => $absence_reservation_employeess,  "current_absence_reservation" => $current_absence_reservation]);

        $mpdf->outPut('I');
    }


    ////////////////////single fiche functions ////////////////////////////////////////////

    public function single_index(Request $request)

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

        /* $establishment = session()->get("establishment");
        if (env("APP_ENV", "local") == "local")
            $employees = employee::with(["establishment", "fonction"])->where("AFFECT", "390904");
        else
            $employees = employee::with(["establishment", "fonction"])->where("AFFECT",  $establishment->estab_rawateb_user);
            */
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

        $employees =  $employees->paginate(8);
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
        return view('absence/single/employees-list', ["employees" => $employees, "adms" => $adms, "select_adms" => $select_adms, "select_sitpai" => $select_sitpai, "search" => $search]);
    }


    public function absence_single_print($MATRI)
    {
        $employee = employee::where("MATRI", $MATRI)->first();
        $absence_reservation_employeess = absence_reservation_employee::with(["absence_reservation"])
            ->join('employees', 'absence_reservation_employees.MATRI', '=', 'employees.MATRI')
            ->Where("absence_reservation_employees.MATRI", $MATRI)
            ->get()
            /*   ->groupBy(function ($absence_reservation_employees) {
                return  $absence_reservation_employees->employee->ADM;
            }) */;

        //dd($absence_reservation_employeess);


        /*used to set the value of a configuration option
        determines the maximum number of allowed steps for matching the regular expression.
        This can be useful in preventing certain types of regex-related performance issues.*/

        $mpdf = new CMPDF();
        $mpdf->initialize([]);
        // dd($view_data);
        // dd($view_data);
        $mpdf->viewToPDF('absence/single/pdf-ar', ['absence_reservation_employees' => $absence_reservation_employeess, 'employee' => $employee]);


        $mpdf->outPut('I');
    }
}
