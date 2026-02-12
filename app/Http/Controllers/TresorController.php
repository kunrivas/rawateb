<?php



namespace App\Http\Controllers;

use App\Models\adm;
use App\Helper\CMPDF;
use App\Models\employee;
use Illuminate\Http\Request;
use App\Models\establishment;
use Illuminate\Support\Facades\Validator;
use App\Models\tresor_employee;



class TresorController extends Controller
{

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
        return view('tresor/employees-list', ["employees" => $employees, "adms" => $adms, "select_adms" => $select_adms, "select_sitpai" => $select_sitpai, "search" => $search]);
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


        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $employee_data = $request->except("_token");
        $employee = employee::where("MATRI", $employee_data["MATRI"])->first();
        if ($employee) {
            /*   $employee->MATRI = $employee_data["MATRI"];
            $employee->PRENOMA = $employee_data["PRENOMA"];
            $employee->NOMA = $employee_data["NOMA"];          */
            $employee->DATNAIS = $employee_data["DATNAIS"];
            /*    $employee->NUMSS = $employee_data["NUMSS"]; */
            /*   $employee->NOMPRENOM = $employee_data["NOMPRENOM"]; */
            $employee->NIN = $employee_data["NIN"];
            /*  $employee->RIB = $employee_data["RIB"]; */
            /*   $employee->address = $employee_data["address"]; */
            $employee->save();
            $ae = tresor_employee::updateOrCreate(
                ['MATRI' => $employee_data['MATRI']], // condition
                [
                    'NIN'              => $employee_data['NIN'],
                    'DATNAIS'          => $employee_data['DATNAIS'],
                    'establishment_id' => $employee_data['AFFECT'],
                ]
            );
            return redirect()->route("tresor-list");
        }
    }


    public function show(Request $request)
    {
        $adms = adm::all();
        $employee = employee::where("MATRI", $request->MATRI)->first();
        return view('tresor/edit', ["employee" => $employee, "adms" => $adms]);
    }


    public function print(Request $request)
    {
        if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment");
        $employees = Employee::where('AFFECT', $establishment->estab_rawateb_user)
            ->where('SITPAI', 0)
            ->orderBy('ADM')
            ->get()
            ->groupBy(function ($item) {
                return empty($item->ADM) ? 'بدون إدارة' : $item->ADM;
            });
        // dd($employees);

        //dd($current_tamadres_reservation);
        /*used to set the value of a configuration option
        determines the maximum number of allowed steps for matching the regular expression.
        This can be useful in preventing certain types of regex-related performance issues.*/

        $mpdf = new CMPDF();
        $mpdf->initialize([]);
        // dd($view_data);
        // dd($view_data);
        $mpdf->viewToPDF('tresor/pdf-print', ['employees' => $employees, 'establishment' => $establishment, "phone" => $request->phone]);

        $mpdf->outPut('I');
    }
}
