<?php

namespace App\Http\Controllers\Admin\settings;

use App\Http\Controllers\Controller;
use App\Models\adm;
use App\Models\employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class EmployeeController extends Controller
{

    public function list(Request $request)
    {
        $search = $request->input('search');
        $adms_select = $request->adms_select;
        $adms = adm::all();
        $employees = employee::with(["establishment", "fonction"]);
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
        $employees->appends(['search' => $search, "select_adms" => $select_adms, "select_sitpai" => $select_sitpai]);
        // returning view employees-list with passing parametre employees
        //dd($adms_select);
        return view('admin/settings/employees/employees-list', ["employees" => $employees, "adms" => $adms, "select_adms" => $select_adms, "select_sitpai" => $select_sitpai, "search" => $search]);
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
        return view('admin/settings/employees/edit', ["employee" => $employee, "adms" => $adms]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "MATRI" => "required",
            "PRENOMA" => "required",
            "NOMA" => "required",
            "PRENOM" => "required",
            "NOM" => "required",
            "DATNAIS" => "required",
            "DATENT" => "required",
            /*   "NUMSS" => "required",
            "ADM" => "required",
            "SITFAM" => "required",
            "CATEG" => "required",
            "ECH" => "required",
            "sitpai" => "required", */
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $employee_data = $request->except("_token");
        $employee = employee::where("MATRI", $employee_data["MATRI"])->first();
        if ($employee) {
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
            $employee->SITFAM = $employee_data["SITFAM"];
            $employee->CATEG = $employee_data["CATEG"];
            $employee->ECH = $employee_data["ECH"];
            
            $employee->save();
            return redirect()->route("admin-settings-employee-list");
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(employee $employee)
    {
        //
    }
}
