<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\adm;
use App\Helper\CMPDF;
use App\Models\employee;
use Illuminate\Http\Request;
use App\Models\establishment;
use App\Models\tresor_employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


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
        /*  if (env("APP_ENV", "local") == "local")
            $employees = employee::with(["establishment", "fonction"])->where("AFFECT", "390904");
        else
            $employees = employee::with(["establishment", "fonction"])->where("AFFECT",  $establishment->estab_rawateb_user); */
        $employees = employee::with(["establishment", "fonction"]);
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
        return view('admin/tresor/employees-list', ["employees" => $employees, "adms" => $adms, "select_adms" => $select_adms, "select_sitpai" => $select_sitpai, "search" => $search]);
    }

    public function showByEstablishment($affect)

    {
        $employees = DB::table('employees')
            ->where('AFFECT', $affect)
            ->where('SITPAI', 0) // optional filter
            ->paginate(20);
        // optional: get establishment name
        $estabName = DB::table('establishments')
            ->where('estab_rawateb_user', $affect)
            ->value('estab_ar_name');

        return view('admin.tresor.estab-employees-list', compact('employees', 'estabName'));
    }


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
            return redirect()->route("admin-tresor-list");
        }
    }


    public function show(Request $request)
    {
        $adms = adm::all();
        $employee = employee::where("MATRI", $request->MATRI)->first();
        return view('admin/tresor/edit', ["employee" => $employee, "adms" => $adms]);
    }


    public function print(Request $request)
    {
        /* if (env("APP_ENV", "local") == "local")
            $establishment = establishment::where("estab_rawateb_user", "390904")->first();
        else
            $establishment = session()->get("establishment"); */
        $employees = Employee::with(["establishment", "fonction"])
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
        $mpdf->viewToPDF('admin/tresor/pdf-print', ['employees' => $employees, 'establishment' => $establishment, "phone" => $request->phone]);

        $mpdf->outPut('I');
    }

    public function stat(Request $request)
    {
        $search = $request->input('search');
        $stats = DB::table('employees as emp')
            ->leftJoin(
                'establishments as est',
                'emp.AFFECT',
                '=',
                'est.estab_rawateb_user'
            )
            ->where('emp.SITPAI', 0)
            ->select(
                'emp.AFFECT',
                DB::raw('MAX(est.estab_ar_name) as estab_ar_name'),
                DB::raw('COUNT(*) as total'),
                DB::raw("
            SUM(
                CASE
                    WHEN TRIM(emp.NIN) <> ''
                    THEN 1 ELSE 0
                END
            ) AS nin_not_empty
        "),
                DB::raw("
            SUM(
                CASE
                    WHEN TRIM(emp.NIN) = ''
                    THEN 1 ELSE 0
                END
            ) AS nin_empty
        ")
            )
            ->groupBy('emp.AFFECT')
            ->get();

        $totalEstabs = $stats->count(); // total establishments
        $estabsEnded = $stats->filter(function ($estab) {
            return $estab->total == $estab->nin_not_empty;
        })->count();
        // all employees in estab have NIN filled
        $estabsStarted = $stats->where('nin_not_empty', '>=', 1)->count();
        // at least 1 employee has NIN filled
        $estabsNotStarted = $stats->where('nin_not_empty', '=', 0)->count();

        // Total employees across all establishments
        $totalEmployees = $stats->sum('total');

        // Total registered employees (with NIN)
        $totalRegistered = $stats->sum('nin_not_empty');
        //  dd($stats); 


        return view('admin.tresor.establishment-list', compact('stats', 'totalEstabs', 'estabsEnded', 'totalEmployees', 'totalRegistered', 'estabsStarted', 'estabsNotStarted'));
    }


    public function exportTresorToSQL()
    {
        $employees = DB::table('employees')
            ->select('MATRI', 'NIN', 'DATNAIS', 'ADM')
            ->whereNotNull('NIN')      // NOT NULL
            ->where('NIN', '!=', '')   // NOT EMPTY
            ->where('SITPAI', 0)
            ->orderBy('ADM')
            ->get()
            ->groupBy(function ($item) {
                return empty($item->ADM) ? '0' : $item->ADM;
            });

        $folder_name = 'tresor_sql_' . now()->format('Ymd_His');
        $base_path = storage_path("app/public/tresor");
        $txt_path = "{$base_path}/sqls/{$folder_name}";

        if (!is_dir("{$base_path}/sqls")) mkdir("{$base_path}/sqls", 0755, true);
        if (!is_dir($txt_path)) mkdir($txt_path, 0755, true);

        $merged_content = "";

        foreach ($employees as $adm => $records) {
            $lines = [];
            foreach ($records as $r) {
                $matri = trim($r->MATRI);
                $NIN = trim($r->NIN);
                $DATNAIS = trim($r->DATNAIS);
                $lines[] = "UPDATE PAPERS{$adm} SET NIN='{$NIN}' WHERE MATRI='{$matri}';";
            }

            $file_content = implode("\n", $lines) . "\n";
            $file_path = "{$txt_path}/adm_{$adm}.txt";
            file_put_contents($file_path, $file_content);

            $merged_content .= "-- ADM {$adm}\n" . $file_content . "\n";
        }

        // Save merged SQL file
        $final_file_name = "{$folder_name}.sql";
        $final_file_path = "{$txt_path}/{$final_file_name}";
        file_put_contents($final_file_path, $merged_content);

        // ✅ Auto download as one file
        return response()->download($final_file_path, $final_file_name, [
            'Content-Type' => 'text/plain',
        ])->deleteFileAfterSend(true);
    }

    public function exportTresorToExcel()
    {
        $employees = DB::table('employees')
            ->select('MATRI', 'NOMA', 'PRENOMA', 'ADM', 'AFFECT', 'NIN', 'DATNAIS', 'address')
            /*   ->whereNotNull('NIN')      // NOT NULL
             ->where('NIN', '!=', '')   // NOT EMPTY */
            ->where('SITPAI', 0)
            ->orderBy('ADM')
            ->get();

        return view("admin.tresor.export-excel", [
            "tresor_employeess" => $employees,
        ]);
    }
}
