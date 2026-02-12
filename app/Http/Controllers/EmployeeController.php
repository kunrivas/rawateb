<?php

namespace App\Http\Controllers;

use App\Models\adm;
use App\Models\employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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

        $select_adms = [];
        if ($request->has("adms")) {
            $select_adms =  array_keys($request->adms);
            $employees = $employees->whereIn("ADM",  $select_adms);
        }
        $select_sitpai = [0];
        if ($request->has("sitpai")) {
            $select_sitpai =  array_keys($request->sitpai);
        }
        $employees = $employees->whereIn("SITPAI",   $select_sitpai);

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
        $employees->appends(['search' => $search]);

        // returning view employees-list with passing parametre employees
        //dd($adms_select);
        return view('salary/employees-list', ["employees" => $employees, "adms" => $adms, "select_adms" => $select_adms, "select_sitpai" => $select_sitpai, "search" => $search]);
    }

    /**
      fun : view megration of employe single
     */

    public function salary_single_list($MATRI)
    {
        $establishment = session()->get("establishment");
        $employees = employee::where("AFFECT", $establishment->estab_rawateb_user)->get();
        return view('salary/employees-list', ["employees" => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {   
        $search = $request->input('search');
        $adms_select = $request->adms_select;
        $adms = adm::all();

        /*var $loginAFFECT is shared by all views  in boot of service provider
        this the way how to call it in  the controller (difference with call in view)
         $loginAFFECT has the establishement AFFECT value of sign in user */
        $establishment = session()->get("establishment");
        if (env("APP_ENV", "local") == "local")
            $employees = employee::with(["establishment", "fonction"])->where("AFFECT", "390904");
        else
            $employees = employee::with(["establishment", "fonction"])->where("AFFECT",  $establishment->estab_rawateb_user);

        $select_adms = [];
        if ($request->has("adms")) {
            $select_adms =  array_keys($request->adms);
            $employees = $employees->whereIn("ADM",  $select_adms);
        }
        $select_sitpai = [0];
        if ($request->has("sitpai")) {
            $select_sitpai =  array_keys($request->sitpai);
        }
        $employees = $employees->whereIn("SITPAI",   $select_sitpai);

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
        $employees->appends(['search' => $search]);

        // returning view employees-list with passing parametre employees
        //dd($adms_select);
        return view('employees/employees-list', ["employees" => $employees, "adms" => $adms, "select_adms" => $select_adms, "select_sitpai" => $select_sitpai, "search" => $search]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "MATRI" => "required",
            "PRENOMA" => "required",
            "NOMA" => "required",
            "PRENOM" => "required",
            "NOM" => "required",
           /*  "DATNAIS" => "required",
            "DATENT" => "required",
            "NUMSS" => "required",
            "ADM" => "required", */
          /*   "sitpai" => "required", */
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $employee_data = $request->except("_token");
        $employee = employee::where("MATRI", $employee_data["MATRI"])->first();
        if ($employee) {
            $employee->MATRI = $employee_data["MATRI"];
            $employee->PRENOMA = $employee_data["PRENOMA"];
            $employee->NOMA = $employee_data["NOMA"];
            $employee->PRENOM = $employee_data["PRENOM"];
            $employee->NOM = $employee_data["NOM"];
            $employee->DATNAIS = $employee_data["DATNAIS"];
            $employee->DATENT = $employee_data["DATENT"];
            $employee->NUMSS = $employee_data["NUMSS"];
            $employee->phone = $employee_data["phone"];
            $employee->address = $employee_data["address"];
            $employee->ADM = $employee_data["ADM"];
            /* $employee->SITPAI = $employee_data["sitpai"]; */
            $employee->save();
            return redirect()->route("settings-employee-list");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $adms = adm::all();
        $employee = employee::where("MATRI", $request->MATRI)->first();
        return view('employees/edit', ["employee" => $employee, "adms" => $adms]);
    }

   
}
