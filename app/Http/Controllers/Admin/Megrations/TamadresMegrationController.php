<?php

namespace App\Http\Controllers\Admin\Megrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ta_megration;
use App\Models\tamadres_megration;
use Carbon\Carbon;
use App\Models\adm;
use App\Models\grant;
use App\Models\emp_ta_megration;
use Illuminate\Support\Facades\DB;
use App\Jobs\Salaryta_megrationJob;
use Illuminate\Support\Facades\File;

class TamadresMegrationController extends Controller
{

    protected $script_path;
    protected $path_folder;

    // if prouction web mode storage path differnt of local mode
    public static function storagePath(): string
    {
        return app()->environment('production')
            ? '/var/www/html/rawateb/storage/app/private'
            : base_path('storage/app/private');
    }

    // tamadres Megration folder path
    public const TAMADRES_MEGRATION_FOLDER = "megration/tamadres";

    public function __construct()
    {
        //$this->script_path= base_path() . DIRECTORY_SEPARATOR.'process'.DIRECTORY_SEPARATOR.'tamadres_megration.py';

        //$this->path_folder = 'public' . DIRECTORY_SEPARATOR . "megration" . DIRECTORY_SEPARATOR . "tamadres" . DIRECTORY_SEPARATOR;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $megrations = ta_megration::orderBy('YEAR', 'desc')->paginate(10);
        return view('admin.megrations.tamadres.list', ["megrations" => $megrations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.megrations.tamadres.add');
    }

    public function store(Request $request)
    {       //dd($request);
        try {
            $ta_megration =    ta_megration::where("YEAR", $request->year)->where('TITLE', $request->title);
            $ta_megration =   $request->has("TITLE") ? $ta_megration->where('TITLE', $request->title)->exists() : $ta_megration->exists();
            if ($ta_megration) {
                return   redirect()->with("هذا الحزمة موجودة مسبقا");
            }

            if (request()->hasFile('ta_megration')) {
                $path_ta_megration = TamadresMegrationController::TAMADRES_MEGRATION_FOLDER . DIRECTORY_SEPARATOR . $request->year . DIRECTORY_SEPARATOR . $request->TRIMESTRE;
                $unzipper  = new \ZipArchive();
                $file = $request->ta_megration->store($path_ta_megration); //store file in storage/app/zip
                // ***   extract zip file to '/var/www/html/rawateb/storage/app/private/megration/rappel_prime/YEAR/TRIMESTRE/extracted'
                $unzipper->open(TamadresMegrationController::storagePath() . DIRECTORY_SEPARATOR . $file);
                $st = $unzipper->extractTo(TamadresMegrationController::storagePath() . DIRECTORY_SEPARATOR . $path_ta_megration . DIRECTORY_SEPARATOR . 'extracted');
                $unzipper->close();

                // add information to the re_megration table  
                $newta_megration =  new  ta_megration();
                $newta_megration->YEAR = $request->year;
                $newta_megration->TITLE = $request->title;
                $newta_megration->LOT = $request->LOT;
                // ***  change in database path data
                $newta_megration->path = TamadresMegrationController::storagePath() . DIRECTORY_SEPARATOR . $path_ta_megration . DIRECTORY_SEPARATOR . 'extracted';
                $newta_megration->save();
                return redirect()->route("admin-megration-tamadres-index")->with("تم إضافة الحزمة بنجاح");
            }
            return   redirect()->with("حدث خطأ الرجاء التأكد من صحة البيانات");
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return   redirect()->with("حدث خطأ الرجاء التأكد من صحة البيانات");
    }

    public function run_ta_megration(Request $request)
    {
        set_time_limit(0);
        //check the file existence
        ini_set('memory_limit', '-1');

        $ta_megration = ta_megration::where("ID_MEGRATION_TA", $request->ID_MEGRATION)->first();

        if ($ta_megration && $ta_megration->STATUS == 0) {
            $ta_megration->RUN = 1;
            $ta_megration->save();


            /*  $cammand = 'python ' . $this->script_path . ' ' . $request->ID_MEGRATION_TA;
            exec($cammand); */


            //if the folder path exisst
            if (file_exists($ta_megration->path)) {
                //read the folder
                $files = scandir($ta_megration->path);
                //This loop iterates over each file in the $files array.
                foreach ($files as $file) {
                    //This condition checks if the current file name contains the string "RAVASIT".
                    if (str_contains($file, "PRPERS")) {
                        /*  use function processPapersFile to  to read excel file (in param file path)
                     and return data[] ARRAY  */
                        $data = $this->processPRPERSFile($ta_megration->path . DIRECTORY_SEPARATOR . $file, $request->ID_MEGRATION);
                        /*   The data returned by processPapersFile is then inserted into the emp_megrations table
                    in chunks of 1000 records to avoid memory overload.
                    array_chunk is useful when you have a large dataset
                    and you want to process it in smaller pieces
                     to avoid memory exhaustion or to improve performance.*/
                        foreach (array_chunk($data, 1000) as $t) {
                            tamadres_megration::insert($t);
                        }
                    }
                }
                // DB::commit();
                //the ta_megration row is finiched execution Now (run => 0)
                $ta_megration->RUN = 0;
                //the ta_megration row not executed (status => 1)
                $ta_megration->STATUS = 1;
                $ta_megration->ACTIVE = 1;
                $ta_megration->save();

                $msg = "تم الرفع بنجاح";
                return redirect()->route('admin-megration-tamadres-index')->with('success', $msg);
            } else {
                $msg = "الملف مفقود";
                return redirect()->route('admin-megration-tamadres-index')->withErrors(['error' => $msg]);
            }
        }
    }

    private function processPRPERSFile($filePath, $ID_MEGRATION)
    {
        $header = null;
        $data = [];

        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($handle, 10000, ';')) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = [
                        'MATRI' =>  strlen($row[0]) == 7 ? "000" . $row[0] : $row[0],
                        'SEQ' => $row[1],
                        'ADM' => $row[2],
                        'DATNAIS' => (!empty($row[8]) && strtotime($row[8]) !== false) ? Carbon::parse($row[8]) : null,
                        'SITFAM' => $row[9],
                        'ENF10' => $row[10],
                        'CODEFONC' => $row[12],
                        'DATENT' => (!empty($row[13]) && strtotime($row[13]) !== false) ? Carbon::parse($row[13]) : null,
                        'DATSOR' => (!empty($row[14]) && strtotime($row[14]) !== false) ? Carbon::parse($row[14]) : null,
                        'NUMSS' => $row[18],
                        'AFFECT' => $row[25],
                        'CATEG' => $row[27],
                        'ECH' => $row[29],
                        'BRUTSS' =>  !empty($row[36]) ? $row[36] : null,
                        'RETSS' =>  !empty($row[37]) ? $row[37] : null,
                        'TOTGAIN' =>  !empty($row[39]) ? $row[39] : null,
                        'NETPAI' => !empty($row[42]) ? $row[42] : null,
                        'PARTSS' => !empty($row[53]) ? $row[53] : null,
                        'TAUX' =>  !empty($row[57]) ? $row[57] : null,
                        'TAUXAF' => !empty($row[67]) ? $row[67] : null,
                        'ENFSCO' => $row[95],
                        'TAUXF' =>  !empty($row[113]) ? $row[113] : null,


                        // Assuming 'ID_MEGRATION_TA' is not included in the CSV file
                        // You can remove this line if ID_MEGRATION_RA is not needed from CSV
                        'ID_MEGRATION_TA' => $ID_MEGRATION,
                    ];
                }
            }
            fclose($handle);
        }
        return $data;
    }


    public function delete(Request $request)
    {
        DB::beginTransaction();

        // Retrieve the ID from the query string
        $ta_megration = ta_megration::find($request->query('ID_MEGRATION'));

        if ($ta_megration) {
            $ta_megration->delete();
            File::deleteDirectory($ta_megration->path);

            tamadres_megration::where('ID_MEGRATION_TA', $request->query('ID_MEGRATION'))->delete();
        }

        DB::commit();

        return redirect()->back();
    }

    public function stat($ID_MEGRATION_TA)
    {

        // Check if the statistics already exist in the megration table
        $ta_megration = ta_megration::where('ID_MEGRATION_TA', $ID_MEGRATION_TA)->first();

        // If the statistics are already saved, return them
        if ($ta_megration && $ta_megration->nbr_employees !== null) {
            return response()->json($ta_megration);
        }

        // Calculate the statistics if not already saved
        $stat_ta_megration = tamadres_megration::join('ta_megrations', 'tamadres_megrations.ID_MEGRATION_TA', '=', 'ta_megrations.ID_MEGRATION_TA')
            ->where('tamadres_megrations.ID_MEGRATION_TA', $ID_MEGRATION_TA)
            ->select(
                'ta_megrations.ID_MEGRATION_TA',
                'ta_megrations.TITLE',
                'ta_megrations.YEAR',
                'ta_megrations.LOT'
            )
            ->selectRaw('
            COUNT(tamadres_megrations.MATRI) as nbr_employees, 
            SUM(tamadres_megrations.NETPAI) as total_NETPAI, 
            SUM(tamadres_megrations.TOTGAIN) as total_TOTGAIN, 
            SUM(tamadres_megrations.RETSS) as total_RETSS, 
            SUM(tamadres_megrations.PARTSS) as total_PARTSS
        ')
            ->groupBy('ta_megrations.ID_MEGRATION_TA', 'ta_megrations.TITLE', 'ta_megrations.YEAR', 'ta_megrations.LOT')
            ->first();
        //dd( $stat_ta_megration);
        if ($stat_ta_megration) {
            // Update the existing row with the calculated statistics
            $ta_megration->update([
                'nbr_employees' => $stat_ta_megration->nbr_employees,
                'total_NETPAI' => $stat_ta_megration->total_NETPAI,
                'total_TOTGAIN' => $stat_ta_megration->total_TOTGAIN,
                'total_RETSS' => $stat_ta_megration->total_RETSS,
                'total_PARTSS' => $stat_ta_megration->total_PARTSS,
            ]);
        }

        // Return the updated row
        return response()->json($ta_megration);
    }
}
