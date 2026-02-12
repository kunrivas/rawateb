<?php

////////*********//////
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use App\Models\adm;
use App\Models\establishment;
use App\Models\rappel_reservation;
use App\Models\rappel_reservation_employee;
use App\Models\RappelReservationsStatistic;
use App\Models\RendemenReservation;
use App\Models\RendementReservation;
use App\Models\RendementReservationEmployee;
use App\Models\RendementReservationsStatistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminRappelReservationController extends Controller
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

        return view("admin.rappel_reservation.list", ["rappelReservations" => $rappelReservations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.rappel_reservation.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rappel_reservation = rappel_reservation::create([
            "YEAR" => $request->YEAR,
            "TITLE" => $request->TITLE,
            "STATUS" => $request->STATUS
        ]);
        return redirect()->route("admin-rappels");
    }

    public function establishmentList(Request $request)
    {
        $search = $request->input('search');

        $rappel_reservation = rappel_reservation::where("rappel_reservation_id", $request->rappel_reservation_id)->first();
        $rappel_reservationsStatistics =  RappelReservationsStatistic::with("establishment")->where("rappel_reservation_id", $request->rappel_reservation_id);
        if (isset($search) && !empty($search)) {


            $rappel_reservationsStatistics =  RappelReservationsStatistic::with(['establishment' => function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('estab_ar_name', 'like', '%' . $search . '%')
                        ->orWhere('estab_rawateb_user', 'like', '%' . $search . '%');
                });
            }])
                ->where("rappel_reservation_id", $request->rappel_reservation_id);


        }
        $rappel_reservationsStatistics = $rappel_reservationsStatistics->paginate(12);
        $statistic["total"] = establishment::whereIn("estab_type", ["ثانوية", "متوسطة"])->count();
        $statistic["start"] = RappelReservationsStatistic::where("rappel_reservation_id", $request->rappel_reservation_id)->count();
        return   view("admin.rappel_reservation.establishment-list", ["search" => $search, "rappel_reservationsStatistics" => $rappel_reservationsStatistics, "statistic" => $statistic, "rappel_reservation" => $rappel_reservation]);
    }
    public function in_establishmentList($rappel_reservation_id, Request $request)
    {
        $search = $request->input('search');
        $establishments =  establishment::whereIn("estab_type", ["ثانوية", "متوسطة"])->whereNotIn("id", RappelReservationsStatistic::select("establishment_id")->where("rappel_reservation_id", $rappel_reservation_id)->get());
        if (isset($search) && !empty($search)) {
            $establishments =    $establishments->where(function ($query) use ($search) {
                $query->where('estab_ar_name', 'like', '%' . $search . '%')
                    ->orWhere('estab_rawateb_user', 'like', '%' . $search . '%');
            });
        }   //to paginate it change ->get by ->paginate(12);
        $establishments = $establishments->paginate(12);
        return   view("admin.rappel_reservation.in-establishment-list", ["rappel_reservation_id" => $rappel_reservation_id, "establishments" => $establishments, "search" => $search]);
    }

    public function reservationEstablishmentList(Request $request)
    {
        $rappelStatistic_id = $request->rappelStatistic_id;
        $rappel_reservations_statistic = RappelReservationsStatistic::with("establishment")->where("id", $rappelStatistic_id)->first();
        $establishment = establishment::where("id",  $rappel_reservations_statistic->establishment_id)->first();

        $rappelReservation = rappel_reservation::where("rappel_reservation_id",  $rappel_reservations_statistic->rappel_reservation_id)->first();

        $rappel_reservations_employees = rappel_reservation_employee::with("employee")->where("rappel_reservation_id", $rappelReservation->rappel_reservation_id)->where("establishment_id", $establishment->id)->get();
        $rappel_reservations_employees_types= $rappel_reservations_employees->groupBy(function ($rappel_reservation_employees) {
            return  $rappel_reservation_employees->rappel_type;
        });

        return view("admin.rappel_reservation.employee-list", ["rappel_reservations_employees_types"=>$rappel_reservations_employees_types,"rappel_reservations_employees" => $rappel_reservations_employees, "rappelReservation" => $rappelReservation, "rappel_reservations_statistic" => $rappel_reservations_statistic]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\adm  $adm
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        $rappel_reservation =  rappel_reservation::where("rappel_reservation_id", $request->id)->first();
        // dd(  $rappel_reservation ,$request);
        $rappel_reservation->STATUS = intval($request->status);
        $rappel_reservation->save();
        return redirect()->route("admin-rappels");
    }
}
