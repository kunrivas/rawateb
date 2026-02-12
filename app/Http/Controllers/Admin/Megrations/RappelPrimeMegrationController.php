<?php

namespace App\Http\Controllers\Admin\Megrations;

use Exception;

use Carbon\Carbon;
use App\Models\adm;
use App\Models\employee;
use Illuminate\Http\Request;
use App\Models\rap_rend_grant;
use App\Models\rap_rend_rasit;
use App\Models\ra_re_megration;
use App\Jobs\SalaryMegrationJob;
use App\Models\rap_rend_megration;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class RappelPrimeMegrationController extends Controller
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

    // rappel_prime Megration folder path
    public const RAPPELPRIME_MEGRATION_FOLDER = "megration/rappel_prime";

    public function __construct()
    {
        //to define folder of megration
        /*  DIRECTORY_SEPARATOR: This is a predefined constant in PHP that represents the directory separator
        for the current operating system (/ for Unix-based systems and \ for Windows).  */
       // $this->path_folder = 'public' . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "megration" . DIRECTORY_SEPARATOR . "rappel_prime" . DIRECTORY_SEPARATOR;
    }

    public function index()
    {
        $megrations = ra_re_megration::orderBy('YEAR', 'desc')->paginate(10);
        return view('admin.megrations.rappel_prime.list', ["megrations" => $megrations]);
    }

    public function create()
    {
        return view('admin.megrations.rappel_prime.add');
    }

    public function store(Request $request)
    {
        try {
            if (ra_re_megration::where("YEAR", $request->year)->where('TITLE', $request->month)->exists()) {
                return   redirect()->with("هذا الحزمة موجودة مسبقا");
            }

            if (request()->hasFile('megration')) {

                  // *** path will be like : 'megration/rappel_prime/YEAR/TRIMESTRE'
                $path_megration = RappelPrimeMegrationController::RAPPELPRIME_MEGRATION_FOLDER . DIRECTORY_SEPARATOR . $request->year . DIRECTORY_SEPARATOR . $request->TRIMESTRE;
                $unzipper  = new \ZipArchive();
                $file = $request->megration->store($path_megration); //store file in storage/app/zip
                 // ***   extract zip file to '/var/www/html/rawateb/storage/app/private/megration/rappel_prime/YEAR/TRIMESTRE/extracted'
                $unzipper->open(RappelPrimeMegrationController::storagePath() . DIRECTORY_SEPARATOR . $file);
                $st = $unzipper->extractTo(RappelPrimeMegrationController::storagePath() . DIRECTORY_SEPARATOR . $path_megration . DIRECTORY_SEPARATOR . 'extracted' );
                $unzipper->extractTo(storage_path($path_megration . DIRECTORY_SEPARATOR . 'extracted'));
                $unzipper->close();

                // add information to the re_megration table  
                $newMegration =  new  ra_re_megration();
                $newMegration->YEAR = $request->year;
                $newMegration->TITLE = $request->TITLE;
                $newMegration->LOT = $request->LOT;
                // ***  change in database path data
                $newMegration->path = RappelPrimeMegrationController::storagePath() . DIRECTORY_SEPARATOR . $path_megration . DIRECTORY_SEPARATOR . 'extracted' ;
                // storage_path($path_re_megration . DIRECTORY_SEPARATOR . 'extracted')
               // $newMegration->log_path = storage_path($path_megration);
                $newMegration->save();
                return redirect()->route("admin-megration-rappel-prime-index")->with("تم إضافة الحزمة بنجاح");
            }
            return   redirect()->with("حدث خطأ الرجاء التأكد من صحة البيانات");
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return   redirect()->with("حدث خطأ الرجاء التأكد من صحة البيانات");
    }

    public function run_megration(Request $request)
    {  // dd($request);
        set_time_limit(0);
        //check the file existence
        ini_set('memory_limit', '-1');
        $megration = ra_re_megration::where("ID_MEGRATION_RA_RE", $request->ID_MEGRATION)->first();
        if ($megration && $megration->STATUS == 0) {
            $megration->RUN = 1;
            $megration->save();
            mb_internal_encoding("UTF-8");
            if (file_exists($megration->path)) {
                //handle the file
                $files = scandir($megration->path);

                foreach ($files as $file) {
                    if (str_contains($file, "RPPERS")) {
                        $data = $this->processRPPERSFile($megration->path . DIRECTORY_SEPARATOR . $file, $request->ID_MEGRATION);
                        //  dd($data);
                        foreach (array_chunk($data, 1000) as $t) {
                            rap_rend_megration::insert($t);
                        }
                        $empdata = $this->processPapersEmpFile($megration->path . DIRECTORY_SEPARATOR . $file, $request->ID_MEGRATION);
                        //dd( $empdata);
                        foreach (array_chunk($empdata, 1000) as $t) {
                            employee::insertOrIgnore($t);
                        }
                    } elseif (str_contains($file, "RPSIT")) {
                        $data = $this->processRPSITFile($megration->path . DIRECTORY_SEPARATOR . $file, $request->ID_MEGRATION);
                        //   dd($data);
                        foreach (array_chunk($data, 1000) as $t) {
                            rap_rend_rasit::insert($t);
                        }
                    } elseif (str_contains($file, "RPVAR")) {
                        $data = $this->processRPVARFile($megration->path . DIRECTORY_SEPARATOR . $file, $request->ID_MEGRATION);

                        foreach (array_chunk($data, 1000) as $t) {
                            rap_rend_grant::insert($t);
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
                return redirect()->route('admin-megration-rappel-prime-index')->with('success', $msg);
            } else {
                $msg = "الملف مفقود";
                return redirect()->route('admin-megration-rappel-prime-index')->withErrors(['error' => $msg]);
            }
        }
    }

    //remplir rap_rend_megration table by  RPPERS excell
    private function processRPPERSFile($filePath, $ID_MEGRATION)
    {
        $header = null;
        $data = [];

        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($handle, 10000, ';')) !== false) {
                if (!$header) {
                    $header = $row;
                    //   dd($header);
                } else {
                    $data[] = [
                        'MATRI' =>  strlen($row[0]) == 7 ? "000" . $row[0] : $row[0],
                        'SEQ' =>      $row[1],
                        'ADM' =>      $row[2],
                        /////////error///////
                        'DATNAIS' =>  !empty($row[8]) ? Carbon::parse($row[8]) : null,
                        'SITFAM' =>   $row[9],
                        'ENF10' =>    $row[10],
                        'CODEFONC' => $row[12],
                        'DATDEB' =>   !empty($row[13]) ? Carbon::parse($row[13]) : null,
                        'DATFIN' =>   !empty($row[14]) ? Carbon::parse($row[14]) : null,
                        'NUMSS' =>    $row[18],
                        'AFFECT' =>   $row[25],
                        'CATEG' =>    $row[27],
                        'ECH' =>      $row[29],
                        'SALBASE' =>   !empty($row[35]) ? $row[35] : null,
                        'BRUTSS' =>   !empty($row[36]) ?  $row[36] : null,
                        'RETSS' =>    !empty($row[37]) ? $row[37] : null,
                        'TOTGAIN' =>    !empty($row[39]) ? $row[39] : null,
                        'RETITS' =>    !empty($row[41]) ? $row[41] : null,
                        'NETPAI' =>    !empty($row[42]) ? $row[42] : null,
                        'PARTSS' =>  !empty($row[53]) ? $row[53] : null,
                        'NBRJ' =>     $row[52],
                        'TAUX' =>      !empty($row[57]) ? $row[57] : null,
                        'JRPRIME' =>   !empty($row[62]) ? $row[62] : null,
                        ///////error///////
                        'TAUXAF' =>    !empty($row[67]) ? $row[67] : null,

                        // Assuming 'ID_MEGRATION_RA' is not included in the CSV file
                        // You can remove this line if ID_MEGRATION_RA is not needed from CSV
                        'ID_MEGRATION_RA_RE' => $ID_MEGRATION,

                    ];
                }
            }
            fclose($handle);
        }
        return $data;
    }

    //remplir rappel_rasit table by  RPSIT excell
    private function processRPSITFile($filePath, $ID_MEGRATION)
    {
        $header = null;
        $data = [];

        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($handle, 10000, ';')) !== false) {
                if (!$header) {
                    $header = $row;
                    //dd($header);
                } else {
                    $data[] = [
                        'MATRI' =>  strlen($row[0]) == 7 ? "000" . $row[0] : $row[0],
                        'SEQ' =>        $row[1],
                        'OLDNEW' =>     $row[2],
                        'ADM' =>        $row[3],
                        'SITFAM' =>     $row[4],
                        'ENF10' =>      $row[5],
                        'CODEFONC' =>   $row[9],
                        'CATEG' =>      $row[12],
                        'ECH' =>        $row[14],
                        'INDICE' =>     $row[15],
                        'SALBASE' =>    !empty($row[19]) ?  $row[19] : null,
                        /////error////
                        'TAUX' =>        !empty($row[21]) ? $row[21] : null,
                        'BRUTSS' =>    !empty($row[24]) ?  $row[24] : null,
                        'RETSS' =>      !empty($row[25]) ? $row[25] : null,
                        'TOTGAIN' =>   !empty($row[27]) ?  $row[27] : null,
                        'RETITS' =>     !empty($row[29]) ? $row[29] : null,
                        'NETPAI' =>    !empty($row[30]) ?  $row[30] : null,
                        /////error////
                        'TAUXAF' =>      !empty($row[45]) ? $row[45] : null,
                        'ENFSCO' =>     $row[68],

                        // Assuming 'ID_MEGRATION_RA' is not included in the CSV file
                        // You can remove this line if ID_MEGRATION_RA is not needed from CSV
                        'ID_MEGRATION_RA_RE' => $ID_MEGRATION,
                    ];
                }
            }
            fclose($handle);
        }
        return $data;
    }

    //remplir rappel_grants table by  RPVAR excell
    private function processRPVARFile($filePath, $ID_MEGRATION)
    {
        $header = null;
        $data = [];

        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($handle, 10000, ';')) !== false) {
                if (!$header) {
                    $header = $row;
                    //dd($header);
                } else {

                    $data[] = [
                        'MATRI' =>  strlen($row[0]) == 7 ? "000" . $row[0] : $row[0],
                        'SEQ' =>        $row[1],
                        'OLDNEW' =>     $row[2],
                        'RG' =>         $row[3],
                        'IND' =>        $row[4],
                        'ADM' =>        $row[5],
                        'BASENBR' =>   !empty($row[6]) ?  $row[6] : null,
                        'TAUX' =>       !empty($row[7]) ? $row[7] : null,
                        'MONTANT' =>    !empty($row[8]) ? $row[8] : null,
                        'MFIX' =>       !empty($row[9]) ? $row[9] : null,
                        'CATEG' =>      $row[10],
                        'SECT' =>       $row[11],
                        'ECH' =>       $row[12],


                        // Assuming 'ID_MEGRATION_RA' is not included in the CSV file
                        // You can remove this line if ID_MEGRATION_RA is not needed from CSV
                        'ID_MEGRATION_RA_RE' => $ID_MEGRATION,
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
                            'NOMA' => $row[5],
                            'PRENOMA' => $row[6],
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
    {
        DB::beginTransaction();
        $megration = ra_re_megration::find($request->ID_MEGRATION);
        $megration->delete();
        File::deleteDirectory($megration->path);

        rap_rend_megration::where("ID_MEGRATION_RA_RE", $request->ID_MEGRATION)->delete();
        rap_rend_rasit::where("ID_MEGRATION_RA_RE", $request->ID_MEGRATION)->delete();
        rap_rend_grant::where("ID_MEGRATION_RA_RE", $request->ID_MEGRATION)->delete();

        DB::commit();
        return redirect()->back();
    }

    public function stat($ID_MEGRATION_RA_RE)
    {
       
        // Check if the statistics already exist in the megration table
        $ra_re_megration = ra_re_megration::where('ID_MEGRATION_RA_RE', $ID_MEGRATION_RA_RE)->first();

        // If the statistics are already saved, return them
        if ($ra_re_megration && $ra_re_megration->nbr_employees !== null) {
            return response()->json($ra_re_megration);
        }

        // Calculate the statistics if not already saved
        $stat_ra_re_megration = rap_rend_megration::join('ra_re_megrations', 'rap_rend_megrations.ID_MEGRATION_RA_RE', '=', 'ra_re_megrations.ID_MEGRATION_RA_RE')
            ->where('rap_rend_megrations.ID_MEGRATION_RA_RE', $ID_MEGRATION_RA_RE)
            ->select(
                'ra_re_megrations.ID_MEGRATION_RA_RE',
                'ra_re_megrations.TITLE',
                'ra_re_megrations.YEAR',
                'ra_re_megrations.LOT'
            )
            ->selectRaw('
            COUNT(rap_rend_megrations.MATRI) as nbr_employees, 
            SUM(rap_rend_megrations.NETPAI) as total_NETPAI, 
            SUM(rap_rend_megrations.TOTGAIN) as total_TOTGAIN, 
            SUM(rap_rend_megrations.RETSS) as total_RETSS, 
            SUM(rap_rend_megrations.PARTSS) as total_PARTSS
        ')
            ->groupBy('ra_re_megrations.ID_MEGRATION_RA_RE', 'ra_re_megrations.TITLE', 'ra_re_megrations.YEAR', 'ra_re_megrations.LOT')
            ->first();
        //dd( $stat_ra_re_megration);
        if ($stat_ra_re_megration) {
            // Update the existing row with the calculated statistics
            $ra_re_megration->update([
                'nbr_employees' => $stat_ra_re_megration->nbr_employees,
                'total_NETPAI' => $stat_ra_re_megration->total_NETPAI,
                'total_TOTGAIN' => $stat_ra_re_megration->total_TOTGAIN,
                'total_RETSS' => $stat_ra_re_megration->total_RETSS,
                'total_PARTSS' => $stat_ra_re_megration->total_PARTSS,
            ]);
        }

        // Return the updated row
        return response()->json($ra_re_megration);
    }
}
