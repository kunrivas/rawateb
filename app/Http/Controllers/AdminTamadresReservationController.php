<?php

namespace App\Http\Controllers\Admin;

use App\Models\employee;
use Illuminate\Http\Request;
use App\Models\establishment;
use App\Http\Controllers\Controller;
use App\Models\tamadres_reservation;
use App\Models\tamadres_reservation_statistic;
use App\Models\tamadres_reservation_employee;

class AdminTamadresReservationController extends Controller
{
    public function index()
    {
        $tamadresReservations =  tamadres_reservation::orderBy("YEAR", "DESC")
            ->paginate(10);
       // dd($tamadresReservations);
        return view("admin.tamadres_reservation.list", ["tamadresReservations" => $tamadresReservations]);
    }

    public function create()
    {
        return view("admin.tamadres_reservation.add");
    }

    public function store(Request $request)
    {

        $tamadres_reservation = tamadres_reservation::create([
            "YEAR" => $request->YEAR,
            "TITLE" => $request->TITLE,
            "STATUS" => $request->STATUS
        ]);
        return redirect()->route("admin-tamadres");
    }
    
    public function status(Request $request)
    {  // dd($request->id);
        $tamadres_reservation =  tamadres_reservation::where("tamadres_reservation_id", $request->id)->first();
        $tamadres_reservation->STATUS = intval($request->status);
        $tamadres_reservation->save();
        return redirect()->route("admin-tamadres");
    }

    public function establishmentList(Request $request)
    {
        $search = $request->input('search');

        $tamadres_reservation = tamadres_reservation::where("tamadres_reservation_id", $request->tamadres_reservation_id)->first();
       
        $tamadres_reservationsStatistics =  tamadres_reservation_statistic::with("establishment")->where("tamadres_reservation_id", $request->tamadres_reservation_id);
       
        if (isset($search) && !empty($search)) {
            $tamadres_reservationsStatistics =  tamadres_reservation_statistic::with(['establishment' => function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('estab_ar_name', 'like', '%' . $search . '%')
                        ->orWhere('estab_rawateb_user', 'like', '%' . $search . '%');
                });
            }])
                ->where("tamadres_reservation_id", $request->tamadres_reservation_id);

        }
        $tamadres_reservationsStatistics = $tamadres_reservationsStatistics->paginate(12);
        $statistic["total"] = establishment::count();
        $statistic["start"] = tamadres_reservation_statistic::where("tamadres_reservation_id", $request->tamadres_reservation_id)->count();
        return   view("admin.tamadres_reservation.establishment-list", ["search" => $search, "tamadres_reservationsStatistics" => $tamadres_reservationsStatistics, "statistic" => $statistic, "tamadres_reservation" => $tamadres_reservation]);
    }

    public function reservationEstablishmentList(Request $request)
    {
        $tamadresStatistic_id = $request->tamadresStatistic_id;
        $tamadres_reservations_statistic = tamadres_reservation_statistic::with("establishment")->where("id", $tamadresStatistic_id)->first();
        $establishment = establishment::where("id",  $tamadres_reservations_statistic->establishment_id)->first();

        $tamadresReservation = tamadres_reservation::where("tamadres_reservation_id",  $tamadres_reservations_statistic->tamadres_reservation_id)->first();

        $tamadres_reservations_employees = tamadres_reservation_employee::with("employee")->where("tamadres_reservation_id", $tamadresReservation->tamadres_reservation_id)->where("establishment_id", $establishment->id)->get();
      /*    $tamadres_reservations_employees_types= $tamadres_reservations_employees->groupBy(function ($tamadres_reservation_employees) {
            return  $tamadres_reservation_employees->NBRCHILDSCO;
        }); */ 
        return view("admin.tamadres_reservation.employee-list", ["tamadres_reservations_employees" => $tamadres_reservations_employees, "tamadresReservation" => $tamadresReservation, "tamadres_reservations_statistic" => $tamadres_reservations_statistic]);
    }

    public function in_establishmentList($tamadres_reservation_id, Request $request)
    {
        $search = $request->input('search');
        $establishments =  establishment::whereNotIn("id", tamadres_reservation_statistic::select("establishment_id")->where("tamadres_reservation_id", $tamadres_reservation_id)->get());
        if (isset($search) && !empty($search)) {
            $establishments =    $establishments->where(function ($query) use ($search) {
                $query->where('estab_ar_name', 'like', '%' . $search . '%')
                    ->orWhere('estab_rawateb_user', 'like', '%' . $search . '%');
            });
        }   //to paginate it change ->get by ->paginate(12);
        $establishments = $establishments->paginate(12);
        return   view("admin.tamadres_reservation.in-establishment-list", ["tamadres_reservation_id" => $tamadres_reservation_id, "establishments" => $establishments, "search" => $search]);
    }
}
