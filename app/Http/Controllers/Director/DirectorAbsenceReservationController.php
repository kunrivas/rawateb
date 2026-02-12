<?php

namespace App\Http\Controllers\Director;

use App\Models\adm;
use App\Helper\CMPDF;
use App\Models\employee;
use Illuminate\Http\Request;
use App\Models\establishment;
use App\Models\dir_absence_reservation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\RappelReservationsStatistic;
use App\Models\dir_absence_reservation_employee;

class DirectorAbsenceReservationController extends Controller
{
    //////////////////////reservation functions////////////////////////////////////////////

    public function index()
    {

        $dir_absence_reservations =  dir_absence_reservation::orderBy("YEAR", "DESC")
            ->orderBy("MONTH", "DESC")->paginate(10);
        return view("director.absence_reservation.list", ["dir_absence_reservations" => $dir_absence_reservations]);
    }

    public function reservationList(Request $request)
    {
        $search = $request->input('search');
        $adms = adm::all();
        $adms_select = $request->adms_select;
        $select_adms = [];

        $dir_absence_reservation_id  = $request->dir_absence_reservation_id;

        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();

        else
            $establishment = session()->get("establishment");

        $dir_absence_reservation = dir_absence_reservation::where("dir_absence_reservation_id", $dir_absence_reservation_id)->first();

        $dir_absence_reservation_employees = dir_absence_reservation_employee::join("employees", "dir_absence_reservation_employees.MATRI", "employees.MATRI")
            //select because the error of delete
            ->select(
                "dir_absence_reservation_employees.*",
                "employees.*",
                "dir_absence_reservation_employees.id as absence_id",
                "employees.id as employee_id"
            )
            ->where("dir_absence_reservation_id", $dir_absence_reservation_id)
            ->where("dir_absence_reservation_employees.estab_mail_code", $establishment->estab_mail_code);

            if (isset($search) && !empty($search)) {
            $dir_absence_reservation_employees =    $dir_absence_reservation_employees->whereHas("employee", function ($query) use ($search) {
                $query->where('NOMA', 'like', '%' . $search . '%')
                    ->orWhere('PRENOMA', 'like', '%' . $search . '%')
                    ->orWhere('MATRI', 'like', '%' . $search . '%');
            });
        }

        $select_adms = [];
        if ($request->has("adms")) {
            $select_adms =  array_keys($request->adms);
            $dir_absence_reservation_employees =    $dir_absence_reservation_employees->whereHas("employee", function ($query) use ($select_adms) {
                $query->whereIn("ADM",   $select_adms);
            });
        }

        $dir_absence_reservation_employees  = $dir_absence_reservation_employees
            ->orderBy("dir_absence_reservation_employees.created_at", "DESC")
            ->GET();

        return view("director.absence_reservation.employees-list", [
            "select_adms" => $select_adms,
            "adms" => $adms,
            "search" => $search,
            "dir_absence_reservation_id" => $dir_absence_reservation_id,
            "dir_absence_reservation_employees" => $dir_absence_reservation_employees,
            "dir_absence_reservation" =>   $dir_absence_reservation
        ]);
    }

    public function getEmployee($MATRI)
    {

        // Fetch establishment data based on the ID
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");
        $employee = employee::with(["establishment", "fonction"])
            ->where("MATRI", "like", "%" . $MATRI . "%")
            //->where("AFFECT", $establishment->estab_rawateb_user)
            ->first();

        //dd($employee);

        // Check if employee exists
        if (!$employee) {
            return response()->json(['error' => 'employee not found'], 404);
        }

        // Return employee data as JSON response
        return response()->json($employee);
    }

    public function insertAbsence(Request $request)
    {
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");
        $validator = Validator::make($request->all(), [
            //  'aMATRI' => 'required',
            'areservationId' => 'required',
            'atype' => 'required',
            'anbrdays' => 'required',
            'adayfrom' => 'required|date',
            'adayto' => 'required|date',

        ]);

        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()->all()], 422);
        $start_abs = $request->input('adayfrom');
        $end_abs = $request->input('adayto');

        $res = dir_absence_reservation_employee::where("MATRI", $request->input('aMATRI'))
            ->where(function ($q) use ($start_abs, $end_abs) {
                $q->whereBetween("DAY_FROM", [$start_abs, $end_abs])
                    ->orWhereBetween("DAY_TO", [$start_abs, $end_abs])
                    ->orWhere(function ($q2) use ($start_abs, $end_abs) {
                        $q2->where("DAY_FROM", "<", $start_abs)
                            ->where("DAY_TO", ">", $end_abs);
                    });
            })->get();

        if ($res->count() == 0) {
            $month = dir_absence_reservation::where("dir_absence_reservation_id", $request->areservationId)->first();
            $res = dir_absence_reservation_employee::where("dir_absence_reservation_id", $month->dir_absence_reservation_id)->where("MATRI",  $request->input('aMATRI'))->sum("NBR_DAYS");
            if (($res + $request->input('anbrdays')) > 30) {
                return ["plus", ($res + $request->input('anbrdays'))];
            }
            if ($month != null && $month->STATUS == 0) {
                return ["end"];
            }

            $ae = dir_absence_reservation_employee::create([
                'MATRI'             => $request->input('aMATRI'),
                'dir_absence_reservation_id'    => $request->input('areservationId'),
                'ABSENCE_TYPE'       => $request->input('atype'),
                'NBR_DAYS'             => $request->input('anbrdays'),
                'DAY_FROM'          => $request->input('adayfrom'),
                'DAY_TO'          => $request->input('adayto'),
                'estab_mail_code' => $establishment->estab_mail_code,
                'ACTIVE' => 0,
            ]);

            return ["add", $ae];
        }
        return  ["deplicated", $res];
    }

    public function destroy($id)
    { //dd($id);
        $dir_absence_reservation_employee = dir_absence_reservation_employee::findOrFail($id);
        if ($dir_absence_reservation_employee->ACTIVE == 0)
            $dir_absence_reservation_employee->delete();
        return redirect()->back();
    }

    public function dir_absence_reservation_print(Request $request)
    {

        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");

        $current_dir_absence_reservation = dir_absence_reservation::where('dir_absence_reservation_id', $request->dir_absence_reservation_id)->first();
        if ($current_dir_absence_reservation  === null) {
            return redirect()->back();
        }

        $dir_absence_reservation_employees = dir_absence_reservation_employee::join('employees', 'dir_absence_reservation_employees.MATRI', '=', 'employees.MATRI')
            ->Where("dir_absence_reservation_employees.dir_absence_reservation_id", $current_dir_absence_reservation->dir_absence_reservation_id)
            ->Where("dir_absence_reservation_employees.estab_mail_code", $establishment->estab_mail_code)
            ->get()
            ->groupBy(function ($dir_absence_reservation_employee) {
                return  $dir_absence_reservation_employee->employee->ADM;
            });


        /*used to set the value of a configuration option
        determines the maximum number of allowed steps for matching the regular expression.
        This can be useful in preventing certain types of regex-related performance issues.*/

        $mpdf = new CMPDF();
        $mpdf->initialize([]);
        // dd($view_data);
        // dd($view_data);
        $mpdf->viewToPDF('director/absence_reservation/pdf-ar', ['dir_absence_reservation_employeess' => $dir_absence_reservation_employees,  "current_dir_absence_reservation" => $current_dir_absence_reservation, "establishment" => $establishment]);

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
        return view('absence/single/employees-list', ["employees" => $employees, "adms" => $adms, "select_adms" => $select_adms, "select_sitpai" => $select_sitpai, "search" => $search]);
    }


    public function absence_single_print($id)
    {

        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");
        $dir_absence_reservation_employee = dir_absence_reservation_employee::findOrFail($id);
        if (!$dir_absence_reservation_employee || $dir_absence_reservation_employee->estab_mail_code != $establishment->estab_mail_code) {
            redirect()->back();
        }

        $employee = employee::where("MATRI", $dir_absence_reservation_employee->MATRI)->first();
        $mpdf = new CMPDF();
        $mpdf->initialize([]);
        // dd($view_data);
        // dd($view_data);
        $mpdf->viewToPDF('director/absence_reservation/single-pdf-ar', ['dir_absence_reservation_employee' =>  $dir_absence_reservation_employee, 'employee' => $employee, "establishment" => $establishment]);


        $mpdf->outPut('I');
    }
}
