<?php

namespace App\Http\Controllers\Admin\Megrations;

use Exception;
use Carbon\Carbon;
use App\Models\adm;
use App\Models\grant;
use App\Models\employee;
use App\Models\megration;
use App\Models\ra_megration;
use App\Models\rappel_grant;
use App\Models\rappel_rasit;
use Illuminate\Http\Request;
use App\Models\emp_megration;
use App\Jobs\SalaryMegrationJob;
use App\Models\rappel_grant_due;
use App\Models\rappel_megration;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class RappelMegrationController extends Controller
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

    // rappel Megration folder path
    public const RAPPEL_MEGRATION_FOLDER = "megration/rappel";

    public function __construct()
    {  

        //to define folder of megration
        //$this->path_folder = 'public' . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "megration" . DIRECTORY_SEPARATOR . "rappel" . DIRECTORY_SEPARATOR;
    }

    public function index()
    {
        $megrations = ra_megration::orderBy('YEAR', 'desc')->paginate(10);
        return view('admin.megrations.rappel.list', ["megrations" => $megrations]);
    }


    public function create()
    {
        return view('admin.megrations.rappel.add');
    }

    public function store(Request $request)
    {
        try {
            if (ra_megration::where("YEAR", $request->year)->where('TITLE', $request->title)->exists()) {
                return   redirect()->with("هذا الحزمة موجودة مسبقا");
            }

            if (request()->hasFile('megration')) {
                $path_megration =RappelMegrationController::RAPPEL_MEGRATION_FOLDER . DIRECTORY_SEPARATOR . $request->year . DIRECTORY_SEPARATOR . $request->TRIMESTRE;
                $unzipper  = new \ZipArchive();
                $file = $request->megration->store($path_megration); //store file in storage/app/zip
                   // ***   extract zip file to '/var/www/html/rawateb/storage/app/private/megration/rappel/YEAR/TRIMESTRE/extracted'
                 $unzipper->open(RappelMegrationController::storagePath() . DIRECTORY_SEPARATOR . $file);
                $st = $unzipper->extractTo(RappelMegrationController::storagePath() . DIRECTORY_SEPARATOR . $path_megration . DIRECTORY_SEPARATOR . 'extracted' );
                $unzipper->close();

                // add information to the re_megration table  
                $newMegration =  new  ra_megration();
                $newMegration->YEAR = $request->year;
                $newMegration->TITLE = $request->TITLE;
                $newMegration->LOT = $request->LOT;
                 // ***  change in database path data
                $newMegration->path = RappelMegrationController::storagePath() . DIRECTORY_SEPARATOR . $path_megration . DIRECTORY_SEPARATOR . 'extracted' ;
               // $newMegration->log_path = storage_path($path_megration);
                $newMegration->save();
                return redirect()->route("admin-megration-rappel-index")->with("تم إضافة الحزمة بنجاح");
            }
            return   redirect()->with("حدث خطأ الرجاء التأكد من صحة البيانات");
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return   redirect()->with("حدث خطأ الرجاء التأكد من صحة البيانات");
    }

    public function run_megration(Request $request)
    {
        set_time_limit(0);
        //check the file existence
        ini_set('memory_limit', '-1');
        $megration = ra_megration::where("ID_MEGRATION_RA", $request->ID_MEGRATION)->first();
        //  dd(  $megration );
        if ($megration && $megration->STATUS == 0) {
            $megration->RUN = true;
            $megration->save();
            mb_internal_encoding("UTF-8");
            if (is_dir($megration->path)) {
                $files = scandir($megration->path);
                //   dd($files);

                foreach ($files as $file) {
                    if (str_contains($file, "RAVASIT")) {

                        $data = $this->processRavasitile($megration->path . DIRECTORY_SEPARATOR . $file, $request->ID_MEGRATION);
                        foreach (array_chunk($data, 1000) as $t) {

                            rappel_grant::insert($t);
                        }
                    } elseif (str_contains($file, "RAPPEL")) {
                        $data = $this->processRappelFile($megration->path . DIRECTORY_SEPARATOR . $file, $request->ID_MEGRATION);
                        foreach (array_chunk($data, 1000) as $t) {
                            rappel_megration::insert($t);
                        }
                        $empdata = $this->processPapersEmpFile($megration->path . DIRECTORY_SEPARATOR . $file, $request->ID_MEGRATION);
                        //dd( $empdata);
                        foreach (array_chunk($empdata, 1000) as $t) {
                            employee::insertOrIgnore($t);
                        }
                    } elseif (str_contains($file, "RASIT")) {
                        $data = $this->processRasitFile($megration->path . DIRECTORY_SEPARATOR . $file, $request->ID_MEGRATION);

                        foreach (array_chunk($data, 1000) as $t) {
                            rappel_rasit::insert($t);
                        }
                    } elseif (str_contains($file, "RAVAR")) {
                        $data = $this->processRavarFile($megration->path . DIRECTORY_SEPARATOR . $file, $request->ID_MEGRATION);
                        foreach (array_chunk($data, 1000) as $t) {
                            rappel_grant_due::insert($t);
                        }
                    }
                }
                // DB::commit();
                //the megration row is finiched execution Now (run => 0)
                $megration->RUN = 0;
                //the megration row not executed (status => 1)
                $megration->STATUS = 1;
                $megration->ACTIVE = 1;
                $megration->save();

                $msg = "تم الرفع بنجاح";
                return redirect()->route('admin-megration-rappel-index')->with('success', $msg);
            } else {
                $msg = "الملف مفقود";
                return redirect()->route('admin-megration-rappel-index')->withErrors(['error' => $msg]);
            }
        }
    }

    private function processRappelFile($filePath, $ID_MEGRATION)
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
                        'CODEFONC' => $row[12],
                        'DATDEB' => Carbon::parse($row[13]) ?? "",
                        'DATFIN' => Carbon::parse($row[14]) ?? "",
                        'CATEG' => $row[27],
                        'ECH' => $row[29],
                        'TOTGAIN' =>  !empty($row[38]) ? $row[38] : null,
                        'NETPAI' =>  !empty($row[41]) ? $row[41] : null,
                        'RETSS' =>  !empty($row[36]) ? $row[36] : null,
                        'PARTSS' =>  !empty($row[55]) ? $row[55] : null,
                        'NBRJ' => $row[48],
                        'NUMCPT' => $row[23],
                        'CLECPT' => $row[58],
                        'NUMSS' => $row[18],
                        'JRABS' => !empty($row[64]) ? $row[64] : null,
                        // Assuming 'ID_MEGRATION_RA' is not included in the CSV file
                        // You can remove this line if ID_MEGRATION_RA is not needed from CSV
                        'ID_MEGRATION_RA' => $ID_MEGRATION,
                    ];
                }
            }
            fclose($handle);
        }
        return $data;
    }

    private function processRavasitile($filePath, $ID_MEGRATION)
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
                        'OLDNEW' => $row[2],
                        'IND' => $row[4],
                        'RG' => $row[3],
                        'ADM' => $row[5],
                        'BASENBR' => $row[6],
                        'TAUX' =>  !empty($row[7]) ? $row[7] : null,
                        'MONTANT' =>  !empty($row[8]) ? $row[8] : null,
                        'MFIX' =>  !empty($row[9]) ? $row[9] : null,
                        'CATEG' => $row[10],
                        'SECT' => $row[11],
                        'ECH' => $row[12],
                        // Assuming 'ID_MEGRATION_RA' is not included in the CSV file
                        // You can remove this line if ID_MEGRATION_RA is not needed from CSV
                        'ID_MEGRATION_RA' => $ID_MEGRATION,
                    ];
                }
            }
            fclose($handle);
        }
        return $data;
    }

    private function processRasitFile($filePath, $ID_MEGRATION)
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
                        'ADM' => $row[3],
                        'OLDNEW' => $row[2],
                        'SITFAM' => $row[4],
                        'ENF10' => $row[5],
                        'CODEFONC' => $row[9],
                        'CATEG' => $row[12],
                        'ECH' => $row[14],
                        'BRUTSS' =>  !empty($row[20]) ? $row[20] : null,
                        'RETSS' =>  !empty($row[21]) ? $row[21] : null,
                        'TOTGAIN' =>  !empty($row[23]) ? $row[23] : null,

                        // Assuming 'ID_MEGRATION_RA' is not included in the CSV file
                        // You can remove this line if ID_MEGRATION_RA is not needed from CSV
                        'ID_MEGRATION_RA' => $ID_MEGRATION,
                    ];
                }
            }
            fclose($handle);
        }
        return $data;
    }

    private function processRavarFile($filePath, $ID_MEGRATION)
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
                        'OLDNEW' => $row[2],
                        'IND' => $row[4],
                        'RG' => $row[3],
                        'ADM' => $row[5],
                        'BASENBR' =>  !empty($row[6]) ? $row[6] : null,
                        'TAUX' =>  !empty($row[7]) ? $row[7] : null,
                        'MONTANT' =>  !empty($row[8]) ? $row[8] : null,
                        'MFIX' =>  !empty($row[9]) ? $row[9] : null,
                        'CATEG' => $row[10],
                        'SECT' => $row[11],
                        'ECH' => $row[12],
                        // Assuming 'ID_MEGRATION_RA' is not included in the CSV file
                        // You can remove this line if ID_MEGRATION_RA is not needed from CSV
                        'ID_MEGRATION_RA' => $ID_MEGRATION,
                    ];
                }
            }
            fclose($handle);
        }
        return $data;
    }

    private function processPapersEmpFile($filePath, $ID_MEGRATION)
    {
        $header = null;
        $data = [];
        $sourceEncoding = 'Windows-1256'; // Specify the excel source encoding here

        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($handle, 10000, ';')) !== false) {

                // Convert each field to UTF-8 using iconv
                $row = array_map(function ($field) use ($sourceEncoding) {
                    $convertedField = iconv($sourceEncoding, 'UTF-8//IGNORE', $field);
                    if ($convertedField === false) {
                        throw new Exception("Error converting field encoding from $sourceEncoding to UTF-8");
                    }
                    return $convertedField;
                }, $row);

                if (!$header) {
                    $header = $row;
                    //  dd($header);
                } else {

                    if ($row[16] == 0) {
                        $data[] = [
                            'MATRI' =>  strlen($row[0]) == 7 ? "000" . $row[0] : $row[0],
                            'NOM' => $row[3],
                            'PRENOM' => $row[4],
                            'NOMA' => $row[6],
                            'PRENOMA' => $row[7],
                            'DATNAIS' => !empty($row[8]) ? Carbon::parse($row[8]) : null,
                            'DATENT' => !empty($row[13]) ? Carbon::parse($row[13]) : null,
                            'NUMSS' => $row[18],
                            'AFFECT' => $row[25],
                            'CODEFONC' => $row[12],
                            'ADM' => $row[2],
                            'SITFAM' => $row[9],
                            'CATEG' => $row[27],
                            'ECH' => $row[29],
                            // Assuming 'ID_MEGRATION_RA' is not included in the CSV file
                            // You can remove this line if ID_MEGRATION_RA is not needed from CSV
                            //'ID_MEGRATION' => $ID_MEGRATION,
                        ];
                    }
                }
            }
            fclose($handle);
        }
        return $data;
    }

    public function delete(Request $request)
    {    //dd($request);
        DB::beginTransaction();
        $megration = ra_megration::find($request->ID_MEGRATION);
        $megration->delete();
        File::deleteDirectory($megration->path);

        rappel_megration::where("ID_MEGRATION_RA", $request->ID_MEGRATION)->delete();
        rappel_rasit::where("ID_MEGRATION_RA", $request->ID_MEGRATION)->delete();
        rappel_grant::where("ID_MEGRATION_RA", $request->ID_MEGRATION)->delete();
        rappel_grant_due::where("ID_MEGRATION_RA", $request->ID_MEGRATION)->delete();

        DB::commit();
        return redirect()->back();
    }

    public function stat($ID_MEGRATION_RA)
    {
       
        // Check if the statistics already exist in the megration table
        $ra_megration = ra_megration::where('ID_MEGRATION_RA', $ID_MEGRATION_RA)->first();

        // If the statistics are already saved, return them
        if ($ra_megration && $ra_megration->nbr_employees !== null) {
            return response()->json($ra_megration);
        }

        // Calculate the statistics if not already saved
        $stat_ra_megration = rappel_megration::join('ra_megrations', 'rappel_megrations.ID_MEGRATION_RA', '=', 'ra_megrations.ID_MEGRATION_RA')
            ->where('rappel_megrations.ID_MEGRATION_RA', $ID_MEGRATION_RA)
            ->select(
                'ra_megrations.ID_MEGRATION_RA',
                'ra_megrations.TITLE',
                'ra_megrations.YEAR',
                'ra_megrations.LOT'
            )
            ->selectRaw('
            COUNT(rappel_megrations.MATRI) as nbr_employees, 
            SUM(rappel_megrations.NETPAI) as total_NETPAI, 
            SUM(rappel_megrations.TOTGAIN) as total_TOTGAIN, 
            SUM(rappel_megrations.RETSS) as total_RETSS, 
            SUM(rappel_megrations.PARTSS) as total_PARTSS
        ')
            ->groupBy('ra_megrations.ID_MEGRATION_RA', 'ra_megrations.TITLE', 'ra_megrations.YEAR', 'ra_megrations.LOT')
            ->first();
        //dd( $stat_ra_megration);
        if ($stat_ra_megration) {
            // Update the existing row with the calculated statistics
            $ra_megration->update([
                'nbr_employees' => $stat_ra_megration->nbr_employees,
                'total_NETPAI' => $stat_ra_megration->total_NETPAI,
                'total_TOTGAIN' => $stat_ra_megration->total_TOTGAIN,
                'total_RETSS' => $stat_ra_megration->total_RETSS,
                'total_PARTSS' => $stat_ra_megration->total_PARTSS,
            ]);
        }

        // Return the updated row
        return response()->json($ra_megration);
    }
}
