<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\adm;
use App\Helper\CMPDF;
use App\Models\employee;
use App\Models\establishment;
use App\Models\absence_reservation;
use Illuminate\Support\Facades\Validator;
use App\Models\RappelReservationsStatistic;
use App\Models\absence_reservation_employee;
use App\Models\absence_reservation_statistic;

class AbsenceController extends Controller
{
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
        return view('admin/absence/employees-list', ["employees" => $employees, "adms" => $adms, "select_adms" => $select_adms, "select_sitpai" => $select_sitpai, "search" => $search]);
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
        $mpdf->viewToPDF('admin/absence/pdf-ar', ['absence_reservation_employees' => $absence_reservation_employeess, 'employee' => $employee]);


        $mpdf->outPut('I');
    }
}
