<?php

////////*********//////
namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;


use App\Models\adm;
use App\Models\establishment;
use App\Models\RendemenReservation;
use App\Models\RendementReservation;
use App\Models\RendementReservationEmployee;
use App\Models\RendementReservationsStatistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;

class AdminRendementReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rendementReservations =  RendementReservation::orderBy("YEAR", "DESC")
            ->orderBy("TRIMESTRE", "DESC")
            ->paginate(10);
        $adms = adm::all();

        return view("admin.rendement_reservation.list", ["adms" => $adms, "rendementReservations" => $rendementReservations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.rendement_reservation.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   //verify if the trimestre is exisst and return error if that
        if (RendementReservation::where("TRIMESTRE", $request->TRIMESTRE)->where("year", $request->year)->count() > 0)
            return redirect()->back()->withErrors("هذا الثلاثي موجود مسبقا");
        //store it
        $rendementReservations = RendementReservation::create([
            "TRIMESTRE" => $request->TRIMESTRE,
            "year" => $request->year,
            "status" => $request->status
        ]);
        return redirect()->route("admin-rendements");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $RendemenReservations = RendementReservation::all();
        return   $RendemenReservations;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\adm  $adm
     * @return \Illuminate\Http\Response
     */

    /*
     establishmentList function when click btn "معاينة"
     */
    public function establishmentList(Request $request)
    {
        $search = $request->input('search');
        /* get rendement reservation table */
        $rendementReservation = RendementReservation::where("id", $request->rendement_reservations_id)->first();
        // get rendementReservationsStatistics table
        $rendementReservationsStatistics =  RendementReservationsStatistic::with("establishment")->where("rendement_reservations_id", $request->rendement_reservations_id);
        // search by estab-ar-name or estab-rawateb-user
        if (isset($search) && !empty($search)) {
            $rendementReservationsStatistics = DB::table('rendement_reservations_statistics')
                ->join('dbmain.establishments', 'rendement_reservations_statistics.establishment_id', '=', 'establishments.id')
                ->where('rendement_reservations_statistics.rendement_reservations_id', $request->rendement_reservations_id)
                ->where(function ($query) use ($search) {
                    $query->where('establishments.estab_ar_name', 'like', '%' . $search . '%')
                        ->orWhere('establishments.estab_rawateb_user', 'like', '%' . $search . '%');
                })
                ->select(
                    'rendement_reservations_statistics.*',
                    'establishments.estab_ar_name',
                    'establishments.estab_rawateb_user'
                );
            // ->paginate(12); // Pagination applied here
        } else {
            $rendementReservationsStatistics = DB::table('rendement_reservations_statistics')
                ->join('dbmain.establishments', 'rendement_reservations_statistics.establishment_id', '=', 'establishments.id')
                ->where('rendement_reservations_statistics.rendement_reservations_id', $request->rendement_reservations_id)
                ->select(
                    'rendement_reservations_statistics.*',
                    'establishments.estab_ar_name',
                    'establishments.estab_rawateb_user'
                );
            //     ->paginate(12); // Pagination applied here
        }
        /*


           $query->where(function ($query) use ($search) {
                    $query->where('estab_ar_name', 'like', '%' . $search . '%')
                        ->orWhere('estab_rawateb_user', 'like', '%' . $search . '%');
                });*/
        $rendementReservationsStatistics = $rendementReservationsStatistics->paginate(12);
        //the statitistics of  establishements (the cards)
        $statistic["total"] = establishment::whereIn("estab_type", ["ثانوية", "متوسطة", "ابتدائية"])->count();
        $statistic["start"] = RendementReservationsStatistic::where("rendement_reservations_id", $request->rendement_reservations_id)->where("status", 0)->count();
        $statistic["done"] = RendementReservationsStatistic::where("rendement_reservations_id", $request->rendement_reservations_id)->where("status", 1)->count();
        return   view("admin.rendement_reservation.establishment-list", ["search" => $search, "rendementReservationsStatistics" => $rendementReservationsStatistics, "statistic" => $statistic, "rendementReservation" => $rendementReservation]);
    }


    /*
    function in_establishmentList to verify the setabs didn't reserved
    */
    public function in_establishmentList($rendement_reservations_id, Request $request)
    {
        $search = $request->input('search');
        $establishments =  establishment::whereIn("estab_type", ["ثانوية", "متوسطة", "ابتدائية"])->whereNotIn("id", RendementReservationsStatistic::select("establishment_id")->where("rendement_reservations_id", $rendement_reservations_id)->get());
        if (isset($search) && !empty($search)) {
            $establishments =    $establishments->where(function ($query) use ($search) {
                $query->where('estab_ar_name', 'like', '%' . $search . '%')
                    ->orWhere('estab_rawateb_user', 'like', '%' . $search . '%');
            });
        }   //to paginate it change ->get by ->paginate(12);
        $establishments = $establishments->paginate(12);
        return   view("admin.rendement_reservation.in-establishment-list", ["rendement_reservations_id" => $rendement_reservations_id, "establishments" => $establishments, "search" => $search]);
    }


    /*
    function reservationEstablishmentList to operation "معاينة" in shoosen estab row in table
    showing the employees of this estab
   */
    public function reservationEstablishmentList(Request $request)
    {
        $rendementReservationsStatistic_id = $request->rendementStatistic_id;
        $rendement_reservations_statistic = RendementReservationsStatistic::with("establishment")->where("id", $rendementReservationsStatistic_id)->first();
        //to get shoosen establishement by request
        $establishment = establishment::where("id",  $rendement_reservations_statistic->establishment_id)->first();
        // to get employee of this establishement
        $rendementReservation = RendementReservation::where("id",  $rendement_reservations_statistic->rendement_reservations_id)->first();
        //$rendement_reservations_employees = RendementReservationEmployee::with("employee")->where("rendement_reservations_id", $rendementReservation->id)->where("estab_mail_code", $establishment->estab_mail_code)->get();
        $rendement_reservations_employees =
    RendementReservationEmployee::with("employee.adm")
        ->where("rendement_reservations_id", $rendementReservation->id)
        ->where("estab_mail_code", $establishment->estab_mail_code)
        ->get()
        ->groupBy(fn($item) => $item->employee->adm->ADM ?? 'بدون ADM');

        return view("admin.rendement_reservation.employee-list", ["rendement_reservations_employees" => $rendement_reservations_employees, "rendementReservation" => $rendementReservation, "rendement_reservations_statistic" => $rendement_reservations_statistic]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\adm  $adm
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        /*   RendementReservation::destroy($request->id);
        return redirect()->route("admin-rendements");*/
    }



    /*
    function status
   to togle  the status (open =0 /close) of rendemenReservation
   */
    public function status(Request $request)
    {
        $rendemenReservation =  RendementReservation::find($request->id);
        //  dd(intval($request->status));
        $rendemenReservation->status = intval($request->status);
        $rendemenReservation->save();
        return redirect()->route("admin-rendements");
    }

    /*
    function openToEstablishment
   to open  the status (open =0) rendement of shoosen establishement
   */
    public function openToEstablishment(Request $request)
    {
        $rendementReservationsStatistic =  RendementReservationsStatistic::find($request->id);
        $rendementReservationsStatistic->status = 0;
        $rendementReservationsStatistic->save();
        return redirect()->route("admin-rendements-establishments", $rendementReservationsStatistic->rendement_reservations_id);
    }
    function exportRendement(Request $request)
    {
        $rendement_reservations_id = $request->id;
        $rendementReservation = RendementReservation::find($rendement_reservations_id);

        if ($rendementReservation) {
            $name_re = 'rendement_' . $rendementReservation->TRIMESTRE . '_' . $rendementReservation->year;
            $path = DIRECTORY_SEPARATOR . 'rendements' . DIRECTORY_SEPARATOR . 'txts' . DIRECTORY_SEPARATOR . $name_re;
            $path_folder = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . $path);
            $zips_folder = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'rendements' . DIRECTORY_SEPARATOR . 'zips');
            $zip_file = $zips_folder . DIRECTORY_SEPARATOR . $name_re . '.zip';

            // Ensure directories exist
            if (!is_dir($path_folder)) {
                mkdir($path_folder, 0755, true);
            }
            if (!is_dir($zips_folder)) {
                mkdir($zips_folder, 0755, true);
            }

            // Generate TXT files
            $all_rendements = RendementReservationEmployee::with("employee")
                ->where('rendement_reservations_id', $rendement_reservations_id)
                ->whereNotNull('point')
                ->get()
                ->groupBy('employee.ADM');

            foreach ($all_rendements as $adm => $admValue) {
                $content = '';
                foreach ($admValue as $randement) {
                    $content .= "UPDATE PRPERS{$adm} SET TAUX='{$randement->point}', AFFECT='{$randement->affect}' WHERE matri='{$randement->MATRI}';\n";
                }
                $file_path = $path . DIRECTORY_SEPARATOR . "adm_{$adm}.txt";
                Storage::disk("public")->put($file_path, $content);
            }

            // Create ZIP file
            $zip = new \ZipArchive;

            if ($zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== TRUE) {
                return response()->json(['error' => 'Could not create ZIP file'], 500);
            }

            // Add files to ZIP
            $files = scandir($path_folder); // Get all files in directory
            foreach ($files as $file) {
                $file_path = $path_folder . DIRECTORY_SEPARATOR . $file;
                if (is_file($file_path)) {
                    $zip->addFile($file_path, basename($file)); // Add file to ZIP
                }
            }

            $zip->close();

            // Verify ZIP file
            if (!file_exists($zip_file)) {
                return response()->json(['error' => 'ZIP file creation failed'], 500);
            }

            // Download ZIP file
            return response()->download($zip_file, $name_re . '.zip', [
                'Content-Type' => 'application/zip',
            ]);
        }

        return response()->json(['error' => 'No record found'], 404);
    }
    function exportADMRendement(Request $request)
    {
        $rendement_reservations_id = $request->id;
        $adm = $request->ADM; // Ensure ADM is passed in the request
        $rendementReservation = RendementReservation::find($rendement_reservations_id);

        if ($rendementReservation) {
            $name_re = 'rendement_' . $rendementReservation->TRIMESTRE . '_' . $rendementReservation->year;
            $path = DIRECTORY_SEPARATOR . 'rendements' . DIRECTORY_SEPARATOR . 'txts' . DIRECTORY_SEPARATOR . $name_re;

            // Ensure directories exist
            $path_folder = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . $path);
            if (!is_dir($path_folder)) {
                mkdir($path_folder, 0755, true);
            }

            // Fetch rendements for the specified ADM
            $all_rendements = RendementReservationEmployee::join('employees', 'rendement_reservation_employees.MATRI', '=', 'employees.MATRI')
                ->where('rendement_reservations_id', $rendement_reservations_id)
                ->where('employees.ADM', $adm)
                ->whereNotNull('point')
                ->get();

            if ($all_rendements->isEmpty()) {
                return response()->json(['error' => 'No rendements found for the specified ADM'], 404);
            }

            // Generate content for the text file
            $content = '';
            foreach ($all_rendements as $randement) {
                $content .= "UPDATE PRPERS{$adm} SET TAUX='{$randement->point}', AFFECT='{$randement->affect}' WHERE matri='{$randement->MATRI}';\n";
            }

            // Save the content to a text file
            $file_name = "adm_{$adm}.txt";
            $file_path = $path_folder . DIRECTORY_SEPARATOR . $file_name;
            file_put_contents($file_path, $content);

            // Download the text file
            return response()->download($file_path, $file_name, [
                'Content-Type' => 'text/plain',
            ]);
        }

        return response()->json(['error' => 'No record found'], 404);
    }
}
