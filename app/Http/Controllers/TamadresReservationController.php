<?php

namespace App\Http\Controllers;

use App\Models\adm;
use App\Helper\CMPDF;
use App\Models\employee;
use Illuminate\Http\Request;
use App\Models\establishment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\tamadres_reservation;
use Illuminate\Support\Facades\Validator;
use App\Models\tamadres_reservation_employee;
use App\Models\tamadres_reservation_statistic;
use Illuminate\Validation\Rule;

class TamadresReservationController extends Controller
{
    /* to show all tamadres titles  */
    public function index()
    {

        $tamadresReservations = tamadres_reservation::orderBy("YEAR", "DESC")
            ->paginate(10);
        return view('tamadres_reservation/list', ["tamadresReservations" => $tamadresReservations]);
    }

    /* 
    when click معاينة to manage the tamadres prime
     */
    public function reservationList($tamadres_reservation_id, Request $request)
    {
        $search = $request->input('search');
        $adms = adm::all();
        $select_adms = [];

        /*  get establishement  */
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");

        //get the row of tamaderes reservation
        $tamadres_reservation = tamadres_reservation::where("tamadres_reservation_id", $tamadres_reservation_id)->first();


        // to get the all the   rows of  table rendement_reservation_employees with search and filtrage
        $tamadres_reservation_employees = tamadres_reservation_employee::join("employees", "tamadres_reservation_employees.MATRI", "employees.MATRI")
            //select because the error of delete (2 id specify every one)
            ->select("tamadres_reservation_employees.*", "employees.*", "tamadres_reservation_employees.id as tamadres_id", "employees.id as employee_id")
            ->where("tamadres_reservation_id", $tamadres_reservation_id)
            ->where("AFFECT", $establishment->estab_rawateb_user);

        if (isset($search) && !empty($search)) {
            $tamadres_reservation_employees =    $tamadres_reservation_employees->whereHas("employee", function ($query) use ($search) {
                $query->where('NOMA', 'like', '%' . $search . '%')
                    ->orWhere('PRENOMA', 'like', '%' . $search . '%')
                    ->orWhere('MATRI', 'like', '%' . $search . '%');
            });
        }
        $select_adms = [];
        if ($request->has("adms")) {
            $select_adms =  array_keys($request->adms);
            $tamadres_reservation_employees =    $tamadres_reservation_employees->whereHas("employee", function ($query) use ($select_adms) {
                $query->whereIn("ADM",   $select_adms);
            });
        }
        $tamadres_reservation_employees  = $tamadres_reservation_employees->get();


        //STATISTICS
        // to get the  row of shosen trimestre and my establishement  in table tamadres_reservation_STATISCTICS
        $tamadres_reservations_statistic = tamadres_reservation_statistic::where("establishment_id", $establishment->id)
            ->where("tamadres_reservation_id", $tamadres_reservation_id)->first();
        /* if the row doesnt exisst initialize this row 
        by function pre_process */
        if ($tamadres_reservations_statistic == null)
            $this->pre_process($tamadres_reservation, $establishment);

        //returnig the view
        return view(
            'tamadres_reservation/employees-list',
            [
                "tamadres_reservation" => $tamadres_reservation,
                "tamadres_reservation_employees" => $tamadres_reservation_employees,
                "tamadres_reservations_statistic" => $tamadres_reservations_statistic,
                "tamadres_reservation_id" => $tamadres_reservation_id,
                "select_adms" => $select_adms,
                "adms" => $adms,
                "search" => $search
            ]
        );
    }


    /* the function pre_process initialize the row of tamadresReservationsStatistics in the first time 
    */
    private function pre_process($tamadres_reservation, $establishment)
    {
        //get all worked employees (status =1) of my establishement 
        $employees = employee::where("AFFECT",  $establishment->estab_rawateb_user)->where("SITPAI", "0")->get();
        //initialize the row of tamadres_reservation_statistics
        $tamadres_reservation_statistics = tamadres_reservation_statistic::create([
            "RESERVED" => 0,
            "TOTAL" =>    $employees->count(),
            "establishment_id" => $establishment->id,
            "tamadres_reservation_id" => $tamadres_reservation->tamadres_reservation_id
        ]);

        //initialize the rows of tamadres_reservation_employees
        /*   $r_r_employees = $employees->map(function ($emp) use ($tamadres_reservation, $establishment) {
            $r_r_emp = new tamadres_reservation_employee();
            $r_r_emp->MATRI = $emp->MATRI;
            $r_r_emp->tamadres_reservation_id = $tamadres_reservation->tamadres_reservation_id;
            $r_r_emp->NBRCHILD = null;
            return $r_r_emp->toArray(); // Convert model to array
        });
        tamadres_reservation_employee::insert($r_r_employees->all()); */

        return true;
    }

    // Fetch employee data based on the MATRI (search by matri in modal)
    public function getEmployee($MATRI)
    {
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");

        $employee = employee::with("fonction")
            ->where("MATRI", $MATRI)
            ->where("AFFECT", $establishment->estab_rawateb_user)
            ->first();



        // Check if employee not exists return eroor
        if (!$employee) {
            return response()->json(['error' => 'employee not found'], 404);
        }

        // Return employee data as JSON response
        return response()->json($employee);
    }

    //insert the tamadres prime in database 
    public function insertTamadres(Request $request)
    {
        $validator = Validator::make($request->all(), [
            /*  unique because every employee has 1 prime */
            'rMATRI' => [
                'required',
                Rule::unique('tamadres_reservation_employees', 'MATRI')
                    ->where('tamadres_reservation_id', $request->input('rreservationId')),
            ],
            'rreservationId' => 'required',
            'rnbrchild' => 'required',
            'rnotes' => 'nullable|string',
        ]);

        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()->all()], 422);

        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");

        //registe the row in table tamadres_reservation_employees
        $ae = tamadres_reservation_employee::create([
            'MATRI'             => $request->input('rMATRI'),
            'tamadres_reservation_id'    => $request->input('rreservationId'),
            'NBRCHILDSCO'       => $request->input('rnbrchild'),
            'establishment_id' => $establishment->id,
            'tamadres_notes'           => $request->input('rnotes'),

        ]);

        /*  mettre a jour the number of reserved employees 
        in the row of the estab of this employee 
        in table tamadres_reservation_statistic */
        //get the row 
        $tamadres_reservation_statistics  = tamadres_reservation_statistic::where("establishment_id", $establishment->id)->where("tamadres_reservation_id",  $request->input('rreservationId'))->first();
        // change the number of reserved employees
        if ($tamadres_reservation_statistics != null) {
            $tamadres_reservation_statistics->reserved = tamadres_reservation_employee::where("tamadres_reservation_id", $request->input('rreservationId'))->where("establishment_id", $establishment->id)->count();
            $tamadres_reservation_statistics->save();
        }
        // return message of success
        return response()->json(['message' => 'Rappel added successfully'], 200);
    }

    //to delete tamadres prime
    public function destroy($id)
    {
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");

        try {
            DB::beginTransaction();
            /*  delete the row in table tamadres_reservation_employees */
            $tamadres_reservation_employee = tamadres_reservation_employee::findOrFail($id);
            $tamadres_reservation_employee->delete();

            /*  mettre a jour the number of reserved employees 
            in the row of the estab of this employee 
             in table tamadres_reservation_statistic */
            //get the row 
            $tamadres_reservation_statistic  = tamadres_reservation_statistic::where("establishment_id", $establishment->id)
                ->where("tamadres_reservation_id", $tamadres_reservation_employee->tamadres_reservation_id)->first();
            // change the number of reserved employees
            if ($tamadres_reservation_statistic != null) {
                $tamadres_reservation_statistic->reserved = tamadres_reservation_employee::where("tamadres_reservation_id", $tamadres_reservation_employee->tamadres_reservation_id)
                    ->where("establishment_id", $establishment->id)->count();
                $tamadres_reservation_statistic->save();
            }
            DB::commit();
            // in succes return back 
            return redirect()->back();

            //in error rollback and return back with error 
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while deleting the record.');
        }
    }

    /*  to print all the tamdres primes group by adm in every pages */
    public function tamadres_reservation_print(Request $request)
    {
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");

        $current_tamadres_reservation = tamadres_reservation::where('tamadres_reservation_id', $request->tamadres_reservation_id)->first();
        if ($current_tamadres_reservation  === null) {
            return redirect()->back();
        }



        $tamadres_reservation_employees = tamadres_reservation_employee::join('employees', 'tamadres_reservation_employees.MATRI', '=', 'employees.MATRI')
            ->where("employees.AFFECT", $establishment->estab_rawateb_user)
            ->Where("tamadres_reservation_employees.tamadres_reservation_id", $current_tamadres_reservation->tamadres_reservation_id)
            ->get()
            ->groupBy(function ($tamadres_reservation_employees) {
                return  $tamadres_reservation_employees->employee->ADM;
            });


        //dd($current_tamadres_reservation);
        /*used to set the value of a configuration option
        determines the maximum number of allowed steps for matching the regular expression.
        This can be useful in preventing certain types of regex-related performance issues.*/

        $mpdf = new CMPDF();
        $mpdf->initialize([]);
        // dd($view_data);
        // dd($view_data);
        $mpdf->viewToPDF('tamadres_reservation/pdf-tamadres', ['tamadres_reservation_employees' => $tamadres_reservation_employees, 'establishment' => $establishment, "current_tamadres_reservation" => $current_tamadres_reservation, "phone" => $request->phone]);

        $mpdf->outPut('I');
    }
}
