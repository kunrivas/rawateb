<?php

namespace App\Http\Controllers\Admin\Megrations;

use Carbon\Carbon;
use App\Models\adm;
use App\Models\grant;
use App\Models\re_megration;
use Illuminate\Http\Request;
use App\Models\rend_megration;
use App\Models\emp_re_megration;
use Illuminate\Support\Facades\DB;
use App\Jobs\Salaryre_megrationJob;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class RendementMegrationController extends Controller
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

    // Rendement Megration folder path
    public const RENDEMENT_MEGRATION_FOLDER = "megration/rendement";

    
    public function __construct()
    {
        //$this->script_path= base_path() . DIRECTORY_SEPARATOR.'process'.DIRECTORY_SEPARATOR.'rendement_megration.py';    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $megrations = re_megration::orderBy('YEAR', 'desc')->orderBy('TRIMESTRE', 'desc')->paginate(10);
        return view('admin.megrations.rendement.list', ["megrations" => $megrations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.megrations.rendement.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
           /*  $re_megration =    re_megration::where("YEAR", $request->year)->where('TRIMESTRE', $request->TRIMESTRE);
            $re_megration =   $request->has("TITLE") ? $re_megration->where('TITLE', $request->title)->exists() : $re_megration->exists();
            if ($re_megration) {
                return   redirect()->with("هذا الحزمة موجودة مسبقا");
            } */

            if ($request->hasFile('re_megration')) {
                // *** path will be like : 'megration/rendement/YEAR/TRIMESTRE'
                $path_re_megration = RendementMegrationController::RENDEMENT_MEGRATION_FOLDER . DIRECTORY_SEPARATOR . $request->year . DIRECTORY_SEPARATOR . $request->TRIMESTRE;
                $unzipper  = new \ZipArchive();
                // store the requested path in 'app/private/megration/rendement/YEAR/TRIMESTRE'
                $file = $request->re_megration->store($path_re_megration); 
                // ***   extract zip file to '/var/www/html/rawateb/storage/app/private/megration/rendement/YEAR/TRIMESTRE/extracted'
                $unzipper->open(RendementMegrationController::storagePath() . DIRECTORY_SEPARATOR . $file);
                $st = $unzipper->extractTo(RendementMegrationController::storagePath() . DIRECTORY_SEPARATOR . $path_re_megration . DIRECTORY_SEPARATOR . 'extracted' );
                $unzipper->close();
                
                // add information to the re_megration table  
                $newre_megration =  new re_megration();
                $newre_megration->TRIMESTRE = $request->TRIMESTRE;
                $newre_megration->YEAR = $request->year;
                $newre_megration->title = $request->title;
                $newre_megration->path = RendementMegrationController::storagePath() . DIRECTORY_SEPARATOR . $path_re_megration . DIRECTORY_SEPARATOR . 'extracted' ;
                $newre_megration->save();
                
                return redirect()->route("admin-megration-rendement-index")->with("تم إضافة الحزمة بنجاح");
            }
            return   redirect()->with("حدث خطأ الرجاء التأكد من صحة البيانات");
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return   redirect()->with("حدث خطأ الرجاء التأكد من صحة البيانات");
    }




    public function run_re_megration(Request $request)
    {
        set_time_limit(0);
        //check the file existence
        ini_set('memory_limit', '-1');

        $re_megration = re_megration::where("ID_MEGRATION_RE", $request->ID_MEGRATION)->first();

        if ($re_megration && $re_megration->STATUS == 0) {
            $re_megration->RUN = 1;
            $re_megration->save();


            /*  $cammand = 'python ' . $this->script_path . ' ' . $request->ID_MEGRATION_RE;
            exec($cammand); */


            //if the folder path exisst
            if (file_exists($re_megration->path)) {
                //read the folder
                $files = scandir($re_megration->path);
                //This loop iterates over each file in the $files array.
                foreach ($files as $file) {
                    //This condition checks if the current file name contains the string "RAVASIT".
                    if (str_contains($file, "PRPERS")) {
                        /*  use function processPapersFile to  to read excel file (in param file path)
                     and return data[] ARRAY  */
                        $data = $this->processPRPERSFile($re_megration->path . DIRECTORY_SEPARATOR . $file, $request->ID_MEGRATION);
                        /*   The data returned by processPapersFile is then inserted into the emp_megrations table
                    in chunks of 1000 records to avoid memory overload.
                    array_chunk is useful when you have a large dataset
                    and you want to process it in smaller pieces
                     to avoid memory exhaustion or to improve performance.*/
                        foreach (array_chunk($data, 1000) as $t) {
                            rend_megration::insert($t);
                        }
                    }
                }
                // DB::commit();
                //the re_megration row is finiched execution Now (run => 0)
                $re_megration->RUN = 0;
                //the re_megration row not executed (status => 1)
                $re_megration->STATUS = 1;
                $re_megration->ACTIVE = 1;
                $re_megration->save();

                $msg = "تم الرفع بنجاح";
                return redirect()->route('admin-megration-rendement-index')->with('success', $msg);
            } else {
                $msg = "الملف مفقود";
                return redirect()->route('admin-megration-rendement-index')->withErrors(['error' => $msg]);
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
                        'SITFAM' => $row[9],
                        'ENF10' => $row[10],
                        'CODFONC' => $row[12],
                        'DATENT' => (!empty($row[13]) && strtotime($row[13]) !== false) ? Carbon::parse($row[13]) : null,
                        'DATSOR' => (!empty($row[14]) && strtotime($row[14]) !== false) ? Carbon::parse($row[14]) : null,
                        'NUMSS' => $row[18],
                        'AFFECT' => $row[25],
                        'CATEG' => $row[27],
                        'ECH' => $row[29],
                        'IEPSECT' => $row[33],
                        'IEPIND' => $row[34],
                        'SALBASE' =>  !empty($row[35]) ? $row[35] : null,
                        'BRUTSS' =>  !empty($row[36]) ? $row[36] : null,
                        'RETSS' =>  !empty($row[37]) ? $row[37] : null,
                        'TOTGAIN' =>  !empty($row[39]) ? $row[39] : null,
                        'RETITS' =>  !empty($row[41]) ? $row[41] : null,
                        'NETPAI' => !empty($row[42]) ? $row[42] : null,
                        'PARTSS' => !empty($row[53]) ? $row[53] : null,
                        'TAUX' =>  !empty($row[57]) ? $row[57] : null,
                        'JRPRIME' =>  !empty($row[62]) ? $row[62] : null,
                        'JRABS' => !empty($row[63]) ? $row[63] : null,
                        'TAUXAF' => !empty($row[67]) ? $row[67] : null,
                        'TAUXF' =>  !empty($row[113]) ? $row[113] : null,
                        'MONTF' => !empty($row[114]) ? $row[114] : null,
                        
                        // Assuming 'ID_MEGRATION_RE' is not included in the CSV file
                        // You can remove this line if ID_MEGRATION_RA is not needed from CSV
                        'ID_MEGRATION_RE' => $ID_MEGRATION,
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
        $re_megration = re_megration::find($request->ID_MEGRATION);
        $re_megration->delete();
        File::deleteDirectory($re_megration->path);
        // emp__megration::where("ID_re_megration",$request->ID_re_megration)->delete();
        rend_megration::where("ID_MEGRATION_RE", $request->ID_MEGRATION)->delete();
        DB::commit();
        return redirect()->back();
    }

    public function stat($ID_MEGRATION_RE)
    {
       
        // Check if the statistics already exist in the megration table
        $re_megration = re_megration::where('ID_MEGRATION_RE', $ID_MEGRATION_RE)->first();

        // If the statistics are already saved, return them
        if ($re_megration && $re_megration->nbr_employees !== null) {
            return response()->json($re_megration);
        }

        // Calculate the statistics if not already saved
        $stat_re_megration = rend_megration::join('re_megrations', 'rend_megrations.ID_MEGRATION_RE', '=', 're_megrations.ID_MEGRATION_RE')
            ->where('rend_megrations.ID_MEGRATION_RE', $ID_MEGRATION_RE)
            ->select(
                're_megrations.ID_MEGRATION_RE',
                're_megrations.TRIMESTRE',
                're_megrations.YEAR',
                're_megrations.TITLE'
            )
            ->selectRaw('
            COUNT(rend_megrations.MATRI) as nbr_employees, 
            SUM(rend_megrations.NETPAI) as total_NETPAI, 
            SUM(rend_megrations.TOTGAIN) as total_TOTGAIN, 
            SUM(rend_megrations.RETSS) as total_RETSS, 
            SUM(rend_megrations.PARTSS) as total_PARTSS
        ')
            ->groupBy('re_megrations.ID_MEGRATION_RE', 're_megrations.TRIMESTRE', 're_megrations.YEAR', 're_megrations.TITLE')
            ->first();
        //dd( $stat_re_megration);
        if ($stat_re_megration) {
            // Update the existing row with the calculated statistics
            $re_megration->update([
                'nbr_employees' => $stat_re_megration->nbr_employees,
                'total_NETPAI' => $stat_re_megration->total_NETPAI,
                'total_TOTGAIN' => $stat_re_megration->total_TOTGAIN,
                'total_RETSS' => $stat_re_megration->total_RETSS,
                'total_PARTSS' => $stat_re_megration->total_PARTSS,
            ]);
        }

        // Return the updated row
        return response()->json($re_megration);
    }


}
