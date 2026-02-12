<?php

namespace App\Http\Controllers;

use App\Models\adm;
use App\Models\employee;
use App\Models\mouvement;
use Illuminate\Http\Request;
use App\Models\establishment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class MouvementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    ///////////////////////////////////////////////////////////ASK//////////////////////////////////////////////
    /* function index to show all employees*/
    public function index(Request $request)
    {
        $adms = adm::all();
        //variable search has the input from search input
        $search = $request->input('search');
        $adms_select = $request->adms_select;

        if (isset($search) && !empty($search)) {
            $establishment = session()->get("establishment");
            if (env("APP_ENV", "local") == "local")
                $employees = employee::where("AFFECT", '!=', "390904");
            else
                $employees = employee::where("AFFECT", '!=',  $establishment->estab_rawateb_user);


            //dd($request->adms_select);
            if (isset($request->adms_select)) {
                if ($request->adms_select != '0')
                    // dd($request->adms_select);
                    $employees = $employees->where("ADM", $adms_select);
            }

            $employees =    $employees->where(function ($query) use ($search) {
                $query->where('NOMA', 'like', '%' . $search . '%')
                    ->orWhere('PRENOMA', 'like', '%' . $search . '%')
                    ->orWhere('MATRI', 'like', '%' . $search . '%');
            });
            //to paginate it change ->get by ->paginate(12);
            $employees =  $employees->paginate(12);
            // Append the search parameter to the pagination links
            /* it resolve the pbm that when i click the cursor of paginator return all employees
        without search conditions */
            $employees->appends(['search' => $search]);
        } else
            $employees = new  Collection([]);
        // returning view employees-list with passing parametre employees
        //dd($adms_select);
        return view('mouvement/employees-list', ["employees" => $employees, "adms" => $adms, "adms_select" => $adms_select, "search" => $search]);
    }

    /* function mouvement_single_ask to show the shoosen ask employee datas*/
    public function mouvement_single_ask($MATRI)
    {
        //one record (first)
        $employee = employee::where("MATRI", $MATRI)->first();
        //returning  view employee-ask with passing parametre employee (1 employee)
        return view('mouvement/employee-ask', ["employee" => $employee]);
    }

    /* function store to confirm ask employee
    store record mouvement with matri of shoosen employee and the affect of (to and from)*/
    public function store(Request $request)
    {
        // to ignore the sql error of ask same employee many time
        try {
            //the name of  2 btns sent with request  is "clicked"
            //and have 2 value "confirm" and "cancel"
            if ($request->clicked == "confirm") {
                //create new model mouvement
                $mouvement = new mouvement;
                // Set the attributes by vars sent with request
                $mouvement->MATRI = $request->MATRI;
                $mouvement->ESTAB_FROM = $request->FROMAFFECT;
                if (env("APP_ENV", "local") == "local")
                    $mouvement->ESTAB_TO =  "390904";
                else
                    $mouvement->ESTAB_TO = session()->get("establishment")->estab_rawateb_user;
                // Save the model
                $mouvement->save();
                //returning to view of all employyes with success msg
                return redirect()->route('mouvement-single-employees')->with('success', 'تم طلب التحويل بنجاح');
            } else {
                //when click cancel
                //returning to view of all employyes without any modification
                return redirect()->route('mouvement-single-employees');
            }
        } catch (QueryException $e) {
           // dd($e);
            //when face the sql error of ask same employee many time
            //return to the same view with error msg
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    ///////////////////////////////////////////////IN/OUT//////////////////////////////////////////////////

    /* function destroy has id mouvemnt in param to cancel the mouvement
    delet the row of mouvement */
    public function destroy($id)
    {
        $mouvement = mouvement::findOrFail($id);
        $mouvement->delete();
        return redirect()->back();
    }

    //////////////////////////////////////////////////IN///////////////////////////////////////////////////

    /* function in_index to show the employees we receive requests to release them to another estabs*/
    public function in_index()
    {   /*var $loginAFFECT is shared by all views  in boot of service provider
        this the way how to call it in  the controller (difference with call in view)
         $loginAFFECT has the establishement AFFECT value of sign in user */
        $establishment = session()->get("establishment");
        if (env("APP_ENV", "local") == "local")
            $loginAFFECT =  "390904";
        else
            $loginAFFECT = $establishment->estab_rawateb_user;

        $inMouvEmployees = mouvement::with("employee")
            //where condition  of mouvement estab_from equal  tho the shared signin esatb affect 
            ->where("ESTAB_TO",  $loginAFFECT)
            //status ==0 to ignort the validat mouvement (statut =1)
            ->where("STATUS", "0")
            ->get();
        //dd($inMouvEmployees);

        return view('mouvement/IN-employees-list', ["inMouvEmployees" => $inMouvEmployees]);
    }

    /* function edit to validate the mouvement
    has in param the id of mouvement
    change the affect of employee and make status fo mouvement = 1*/
    public function edit($id)
    {    //using transaction to assure all the queries execute completly in same time or doesnt excute completly
        try {
            // Start the transaction
            DB::beginTransaction();

            //find the mouvement by his id
            $mouvement = mouvement::findOrFail($id);
            //change it's status and save it
            $mouvement->STATUS = '1';
            $mouvement->save();
            // find the employee have the matri of this mouvement and update his AFFECT
            employee::where("MATRI", $mouvement->MATRI)
                ->update(['AFFECT' => $mouvement->ESTAB_TO]);

            // Commit the transaction
            DB::commit();
            //returning to same view with success msg
            return redirect()->back()->with('success', 'تم التحويل بنجاح');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollback();
            //returning to same view with error msg
            return redirect()->back()->withErrors(['error' => 'هنالك مشكل في تحويل هذا الموظف']);
        }
    }

    //////////////////////////////////////////////////OUT///////////////////////////////////////////////////
    /* function out_index to show the employees we want to give them from the othe estabs */
    public function out_index()
    {
        /*var $loginAFFECT is shared by all views  in boot of service provider
         this the way how to call it in  the controller (difference with call in view)
          $loginAFFECT has the establishement AFFECT value of sign in user */
        $establishment = session()->get("establishment");

        if (env("APP_ENV", "local") == "local")
            $loginAFFECT =  "390904";
        else
            $loginAFFECT = $establishment->estab_rawateb_user;

        $outMouvEmployees = mouvement::with("employee")
            //where condition  of mouvement estab_to equal  tho the shared signin esatb affect 
            ->where("ESTAB_FROM",  $loginAFFECT)
            //status ==0 to ignort the validat mouvement (statut =1)
            ->where("STATUS", "0")
            ->get();
        //returning view OUT-employees-list wiht passing var outMouvEmployees
        return view('mouvement/OUT-employees-list', ["outMouvEmployees" => $outMouvEmployees]);
    }


    public function employees_list_release(Request $request)

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
         $establishment = session()->get("establishment");
         if (env("APP_ENV", "local") == "local")
            $employees = employee::with(["establishment", "fonction"])->where("AFFECT", "390904");
        else
            $employees = employee::with(["establishment", "fonction"])->where("AFFECT",  $establishment->estab_rawateb_user);




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

        // dd($employees->toSql());
        $employees =  $employees->paginate(12);
        // Append the search parameter to the pagination links
        /* it resolve the pbm that when i click the cursor of paginator return all employees
         without search conditions */
        // dd(request()->input());
        $employees->appends(['search' => $search]);

        // returning view employees-list with passing parametre employees
        //dd($adms_select);
        return view('mouvement/employees-list-release', ["employees" => $employees, "adms" => $adms, "select_adms" => $select_adms, "select_sitpai" => $select_sitpai, "search" => $search]);
    }
    public function release($id)
    {
        $employee = employee::find($id);

        if (!$employee) {
            return back()->with('error', 'الموظف غير موجود.');
        }

        $employee->AFFECT = 1;
        $employee->save();

        return back()->with('success', 'تم تحرير الموظف بنجاح.');
    }
}
