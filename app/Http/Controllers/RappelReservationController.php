<?php

namespace App\Http\Controllers;

use App\Models\adm;
use App\Helper\CMPDF;
use App\Models\employee;
use App\Models\fonction;
use Illuminate\Http\Request;
use App\Models\establishment;
use App\Models\rappel_reservation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\rappel_reservation_employee;
use App\Models\RappelReservationsStatistic;

class RappelReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rappelReservations =  rappel_reservation::orderBy("YEAR", "DESC")
            ->paginate(10);
        $adms = adm::all();
        return view("rappel_reservation.list", ["rappelReservations" => $rappelReservations, "adms" => $adms]);
    }

    public function reservationList(Request $request)
    {
        $search = $request->input('search');
        $adms = adm::all();
        $adms_select = $request->adms_select;
        $select_adms = [];

        $rappel_reservation_id  = $request->rappel_reservation_id;

        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();

        else
            $establishment = session()->get("establishment");

        $rappelReservation = rappel_reservation::where("rappel_reservation_id", $rappel_reservation_id)->first();
        // dd($rapeelReservation);
        $rendement_reservations_statistic  = RappelReservationsStatistic::where("establishment_id", $establishment->id)->where("rappel_reservation_id", $rappel_reservation_id)->first();
        if ($rendement_reservations_statistic == null) {
            $rendement_reservations_statistic = RappelReservationsStatistic::create(["reserved" => 0, "establishment_id" => $establishment->id, "rappel_reservation_id" => $rappelReservation->rappel_reservation_id]);
        }
        $rappel_reservations_employees = rappel_reservation_employee
            ::join("employees", "rappel_reservation_employees.MATRI", "employees.MATRI")
            //select because the error of delete
            ->select("rappel_reservation_employees.*", "employees.*", "rappel_reservation_employees.id as rappel_id", "employees.id as employee_id")
            ->where("rappel_reservation_id", $rappel_reservation_id)
            ->where("AFFECT", $establishment->estab_rawateb_user);

        if (isset($search) && !empty($search)) {
            $rappel_reservations_employees =    $rappel_reservations_employees->whereHas("employee", function ($query) use ($search) {
                $query->where('NOMA', 'like', '%' . $search . '%')
                    ->orWhere('PRENOMA', 'like', '%' . $search . '%')
                    ->orWhere('MATRI', 'like', '%' . $search . '%');
            });
        }
        $select_adms = [];
        if ($request->has("adms")) {
            $select_adms =  array_keys($request->adms);
            $rappel_reservations_employees =    $rappel_reservations_employees->whereHas("employee", function ($query) use ($select_adms) {
                $query->whereIn("ADM",   $select_adms);
            });
        }
        $rappel_reservations_employees  = $rappel_reservations_employees->get();
        return view("rappel_reservation.employees-list", [
            "select_adms" => $select_adms,
            "adms" => $adms,
            "search" => $search,
            "rappel_reservation_id" => $rappel_reservation_id,
            "rappel_reservations_employees" => $rappel_reservations_employees,
            "rapeelReservation" =>   $rappelReservation
        ]);
    }

    public function rappel_reservation_print(Request $request)
    {
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");

        $current_rappel_reservation = rappel_reservation::where('rappel_reservation_id', $request->rappel_reservation_id)->first();
        if ($current_rappel_reservation  === null) {
            return redirect()->back();
        }



        $rappel_reservation_employeess = rappel_reservation_employee::join('employees', 'rappel_reservation_employees.MATRI', '=', 'employees.MATRI')
            ->where("employees.AFFECT", $establishment->estab_rawateb_user)
            ->Where("rappel_reservation_employees.rappel_reservation_id", $current_rappel_reservation->rappel_reservation_id)
            ->get()->groupBy(function ($rappel_reservation_employees) {
                return  $rappel_reservation_employees->employee->ADM;
            });



        /*used to set the value of a configuration option
        determines the maximum number of allowed steps for matching the regular expression.
        This can be useful in preventing certain types of regex-related performance issues.*/

        $mpdf = new CMPDF();
        $mpdf->initialize([]);
        // dd($view_data);
        // dd($view_data);
        $mpdf->viewToPDF('rappel_reservation/pdf-ar', ['rappel_reservation_employeess' => $rappel_reservation_employeess, 'establishment' => $establishment, "current_rappel_reservation" => $current_rappel_reservation, "phone" => $request->phone]);

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

    public function getEmployee($MATRI)
    {
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");
        // Fetch establishment data based on the ID
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");

        $employee = employee::with("fonction")
            ->where("MATRI", $MATRI)
            ->where("AFFECT", $establishment->estab_rawateb_user)
            ->first();



        // Check if establishment exists
        if (!$employee) {
            return response()->json(['error' => 'employee not found'], 404);
        }

        // Return establishment data as JSON response
        return response()->json($employee);
    }



    public function insertRappel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rMATRI' => 'required',
            'rreservationId' => 'required',
            'rtype' => 'required',
            'rvalue' => 'required',
            'rdate' => 'required|date',
            'rnotes' => 'nullable|string',
        ]);
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");
        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()->all()], 422);
        $rendement_reservations_statistic  = RappelReservationsStatistic::where("establishment_id", $establishment->id)->where("rappel_reservation_id",  $request->input('rreservationId'))->first();
        if ($rendement_reservations_statistic == null) {
            $rendement_reservations_statistic = RappelReservationsStatistic::create(["reserved" => 0, "establishment_id" => $establishment->id, "rappel_reservation_id" =>  $request->input('rreservationId')]);
        }
        $ae = rappel_reservation_employee::create([
            'MATRI'             => $request->input('rMATRI'),
            'rappel_reservation_id'    => $request->input('rreservationId'),
            'rappel_type'       => $request->input('rtype'),
            'rappel_val'             => $request->input('rvalue'),
            'rappel_date'          => $request->input('rdate'),
            'establishment_id' => $establishment->id,
            'rapeel_notes'           => $request->input('rnotes'),

        ]);
        $rendement_reservations_statistic->reserved = rappel_reservation_employee::where("rappel_reservation_id", $request->input('rreservationId'))->where("establishment_id", $establishment->id)->count();
        $rendement_reservations_statistic->save();
        return response()->json(['message' => 'Rappel added successfully'], 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");

        $rappel_reservation_employee = rappel_reservation_employee::findOrFail($id);
        $rappel_reservations_statistic  = RappelReservationsStatistic::where("establishment_id", $establishment->id)->where("rappel_reservation_id", $rappel_reservation_employee->rappel_reservation_id)->first();
        if ($rappel_reservations_statistic == null) {
            $rappel_reservations_statistic = RappelReservationsStatistic::create(["reserved" => 0, "establishment_id" => $establishment->id, "rappel_reservation_id" =>  $rappel_reservation_employee->rappel_reservation_id]);
        }
        $rappel_reservation_employee->delete();
        $rappel_reservations_statistic->reserved = rappel_reservation_employee::where("rappel_reservation_id", $rappel_reservations_statistic->rappel_reservation_id)->where("establishment_id", $establishment->id)->count();
        $rappel_reservations_statistic->save();
        return redirect()->back();
    }
}
