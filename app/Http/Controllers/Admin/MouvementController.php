<?php
////////*********//////
namespace App\Http\Controllers\Admin;

use Carbon\Carbon;

use App\Models\adm;
use App\Helper\CMPDF;
use App\Models\employee;
use App\Models\mouvement;
use Illuminate\Http\Request;
use App\Models\establishment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;
use ZipArchive;


class MouvementController  extends Controller
{


    /*function togglePeriod to open or close the mouvement period */
    public function togglePeriod()
    {
        $period = DB::table('mv_megrations')->first();

        if (!$period) {
            // just in case table empty
            DB::table('mv_megrations')->insert([
                'PERIOD_MOUV' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $period = (object) ['PERIOD_MOUV' => 1];
        }

        $newStatus = $period->PERIOD_MOUV == 1 ? 0 : 1;

        DB::table('mv_megrations')->update([
            'PERIOD_MOUV' => $newStatus,
            'updated_at' => now(),
        ]);

        $msg = $newStatus == 1 ? 'تم فتح فترة الحركة بنجاح' : 'تم غلق فترة الحركة بنجاح';

        return redirect()->back()->with('success', $msg);
    }

    //////////////////////////////////////////////////OUT///////////////////////////////////////////////////
    /* function out_index to show the employees we want to give them from the othe estabs */
    public function out_index()
    {

        $outMouvEmployees = mouvement::with("employee")

            //status ==0 to ignort the validat mouvement (statut =1)
            ->where("STATUS", "0")
            ->get();
        //returning view OUT-employees-list wiht passing var outMouvEmployees
        return view('admin/mouvement/OUT-employees-list', ["outMouvEmployees" => $outMouvEmployees]);
    }

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


    public function destroy($id)
    {
        $mouvement = mouvement::findOrFail($id);
        $mouvement->delete();
        return redirect()->back();
    }

    public function print_list(Request $request)
    {
        $adms = adm::all();
        $select_adms = [];
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $mouvEmployees = mouvement::with("employee")->where("STATUS", "1");


        if ($request->has("adms")) {
            $select_adms =  array_keys($request->adms);
            // dd($select_adms);
            $mouvEmployees =  $mouvEmployees->whereHas("employee", function ($query) use ($select_adms) {
                $query->whereIn("ADM", $select_adms);
            });
            //  dd($mouvEmployees);
        }

        if (isset($start_date) && !empty($start_date)) {
            $mouvEmployees = $mouvEmployees->where("updated_at", ">", $start_date)
                ->orwhere("updated_at", "=", $start_date);
        }
        if (isset($end_date) && !empty($end_date)) {
            $mouvEmployees = $mouvEmployees->where("updated_at", "<", $end_date)
                ->orwhere("updated_at", "=", $end_date);
        }

        $mouvEmployees =  $mouvEmployees->get();


        return view('admin/mouvement/print-list', [
            "mouvEmployees" => $mouvEmployees,
            "adms" => $adms,
            "select_adms" => $select_adms,
            "start_date" => $start_date,
            "end_date" => $end_date
        ]);
    }

    public function mouvement_print(Request $request)
    {
        $adms = adm::all();
        $select_adms = [];
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $action = $request->input('action'); // "print" or "excel"

        $mouvEmployees = mouvement::with(["employee", "to_establishment", "from_establishment"])
            ->where("STATUS", "1");

        if ($request->has("adms")) {
            $select_adms = array_keys($request->adms);
            $mouvEmployees = $mouvEmployees->whereHas("employee", function ($query) use ($select_adms) {
                $query->whereIn("ADM", $select_adms);
            });
        }

        if ($start_date) {
            $mouvEmployees = $mouvEmployees->whereDate("updated_at", ">=", $start_date);
        }

        if ($end_date) {
            $mouvEmployees = $mouvEmployees->whereDate("updated_at", "<=", $end_date);
        }

        $mouvEmployees = $mouvEmployees->orderby("updated_at","asc")->get();

        // 🟢 Build view data
        $view_data = collect($mouvEmployees->map(function ($mouvEmployee) {
            return [
                "matri"        => $mouvEmployee->MATRI,
                "ADM"          => $mouvEmployee->employee->ADM ?? '/',
                "firstName"    => $mouvEmployee->employee->PRENOMA ?? '/',
                "familyName"   => $mouvEmployee->employee->NOMA ?? '/',
                "birthDate"    => $mouvEmployee->employee->DATNAIS ? Carbon::parse($mouvEmployee->employee->DATNAIS)->format('Y-m-d') : '/',
                "numCnas"      => $mouvEmployee->employee->NUMSS ?? '/',
                "newEstab"     => $mouvEmployee->to_establishment->estab_ar_name ?? '/',
                "codeNewEstab" => $mouvEmployee->ESTAB_TO ?? '/',
                "oldEstab"     => $mouvEmployee->from_establishment->estab_ar_name ?? '/',
                "codeOldEstab" => $mouvEmployee->ESTAB_FROM ?? '/',
                "fonction"     => $mouvEmployee->employee->fonction->LIBTABA ?? '/',
            ];
        }));

        $view_data_grouped = $view_data->groupBy('ADM');

        // 🔸 If user clicked "Export to SQL"
        if ($action === 'excel') {
            return $this->exportMouvementToSQL($view_data_grouped);
        }

        // 🔸 Otherwise, print PDF
        $mpdf = new CMPDF();
        $mpdf->initialize(['orientation' => 'L']);
        $mpdf->viewToPDF('admin/mouvement/pdf-ar', [
            'data'       => $view_data_grouped,
            'adms'       => $adms,
            'start_date' => $start_date,
            'end_date'   => $end_date,
            'serv'       => []
        ]);
        $mpdf->outPut('I');
    }




 private function exportMouvementToSQL($groupedData)
{
    $folder_name = 'mouvements_sql_' . now()->format('Ymd_His');
    $base_path = storage_path("app/public/mouvements");
    $txt_path = "{$base_path}/sqls/{$folder_name}";

    if (!is_dir("{$base_path}/sqls")) mkdir("{$base_path}/sqls", 0755, true);
    if (!is_dir($txt_path)) mkdir($txt_path, 0755, true);

    $merged_content = "";

    foreach ($groupedData as $adm => $records) {
        $lines = [];
        foreach ($records as $r) {
            $matri = trim($r['matri']);
            $affect = trim($r['codeNewEstab']);
            $lines[] = "UPDATE PAPERS{$adm} SET AFFECT='{$affect}' WHERE MATRI='{$matri}';";
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




    public function emoloyees_list_release(Request $request)

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

        $employees = employee::with(["establishment", "fonction"])->where("AFFECT", "1");;



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
        return view('admin/mouvement/employees-list-release', ["employees" => $employees, "adms" => $adms, "select_adms" => $select_adms, "select_sitpai" => $select_sitpai, "search" => $search]);
    }
    
}
