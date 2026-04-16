<?php

namespace App\Http\Controllers\Admin\Megrations;

use Exception;
use Carbon\Carbon;

use App\Models\adm;
use App\Models\grant;
use App\Models\employee;
use App\Models\megration;
use App\Models\stat_emp_megration;
use Illuminate\Http\Request;
use App\Models\emp_megration;
use App\Jobs\SalaryMegrationJob;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class SalaryMegrationController extends Controller
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

    // salary Megration folder path
    public const SALARY_MEGRATION_FOLDER = "megration/salary";


    /* constructor is a special function that gets called automatically when
     an instance (object) of the class is created.
    */
    public function __construct()
    {   //to define script python
        // $this->script_path = base_path() . DIRECTORY_SEPARATOR . 'process' . DIRECTORY_SEPARATOR . 'salary_megration.py';

        //to define folder of megration
        /*  DIRECTORY_SEPARATOR: This is a predefined constant in PHP that represents the directory separator
        for the current operating system (/ for Unix-based systems and \ for Windows).  */

        /*       The constructed path will look something like this:
        On Windows systems: public\app\megration\salary\ */
        //$this->path_folder = 'public' . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "megration" . DIRECTORY_SEPARATOR . "salary" . DIRECTORY_SEPARATOR;
    }


    public function index()
    {
        //to show the megrations list of salary
        $megrations = megration::orderBy("YEAR", "DESC")
            ->orderBy("MONTH", "DESC")
            ->paginate(10);
        return view('admin.megrations.salary.list', ["megrations" => $megrations]);
    }

    //to show the blade of megrations
    public function create()
    {
        return view('admin.megrations.salary.add');
    }

    /*  to decompres the zip file and save the datas in megrations table */
    public function store(Request $request)
    {
        try {
            if (megration::where("YEAR", $request->year)->where('Month', $request->month)->exists()) {
                return   redirect()->with("هذا الحزمة موجودة مسبقا");
            }

            if (request()->hasFile('megration')) {
                $path_megration = SalaryMegrationController::SALARY_MEGRATION_FOLDER . DIRECTORY_SEPARATOR . $request->year .  DIRECTORY_SEPARATOR . $request->month;
                //unzip the zip file to file
                $unzipper  = new \ZipArchive();
                $file = $request->megration->store($path_megration); //store file in storage/app/zip
                $unzipper->open(SalaryMegrationController::storagePath() . DIRECTORY_SEPARATOR . $file);
                $st = $unzipper->extractTo(SalaryMegrationController::storagePath() . DIRECTORY_SEPARATOR . $path_megration . DIRECTORY_SEPARATOR . 'extracted');
                $unzipper->close();
                //store the megration table datas
                $newMegration =  new  megration();
                $newMegration->Month = $request->month;
                $newMegration->YEAR = $request->year;
                $newMegration->LOT = $request->LOT;
                // ***  change in database path data
                $newMegration->path = SalaryMegrationController::storagePath() . DIRECTORY_SEPARATOR . $path_megration . DIRECTORY_SEPARATOR . 'extracted';
                //$newMegration->log_path = storage_path($path_megration);
                $newMegration->save();
                return redirect()->route("admin-megration-salary-index")->with("تم إضافة الحزمة بنجاح");
            }
            return   redirect()->with("حدث خطأ الرجاء التأكد من صحة البيانات");
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return   redirect()->with("حدث خطأ الرجاء التأكد من صحة البيانات");
    }

    //run megration with python script
    /*  public function run_megration(Request $request)
    {
        $megration = megration::find($request->ID_MEGRATION);
        if ($megration && $megration->STATUS == 0) {
            $megration->STATUS = 1;
            $megration->save();
            $cammand = 'python ' . $this->script_path . ' ' . $request->ID_MEGRATION;
            exec($cammand);
        }
    } */

    //run megration with laravel php
    public function run_megration(Request $request)
    {

        set_time_limit(0);
        //check the file existence
        ini_set('memory_limit', '-1');
        $megration = megration::where("ID_MEGRATION", $request->ID_MEGRATION)->first();
        //if the megration row not executed (status => 0)
        if ($megration && $megration->STATUS == 0) {
            //the megration row is executed Now (run => 1)
            $megration->RUN = 1;
            $megration->save();
            mb_internal_encoding("UTF-8");
            //if the folder path exisst
            if (file_exists($megration->path)) {
                //read the folder
                $files = scandir($megration->path);
                //This loop iterates over each file in the $files array.

                // Fetch all existing MATRI values at once
                //$existingMATRIs = Employee::pluck('MATRI')->toArray();
                // dd( $existingMATRIs);

                foreach ($files as $file) {

                    //This condition checks if the current file name contains the string "RAVASIT".
                    if (str_contains($file, "PAPERS")) {
                        /*  use function processPapersFile to  to read excel file (in param file path)
                         and return data[] ARRAY  */

                        $data = $this->processPapersFile($megration->path . DIRECTORY_SEPARATOR . $file, $request->ID_MEGRATION);
                        // dd( $data);
                        /*   The data returned by processPapersFile is then inserted into the emp_megrations table
                        in chunks of 1000 records to avoid memory overload.
                        array_chunk is useful when you have a large dataset
                        and you want to process it in smaller pieces
                         to avoid memory exhaustion or to improve performance.*/
                        foreach (array_chunk($data, 1000) as $t) {
                            emp_megration::insert($t);
                        }

                        $empdata = $this->processPapersEmpFile($megration->path . DIRECTORY_SEPARATOR . $file, $request->ID_MEGRATION);
                        //dd( $empdata);
                        foreach (array_chunk($empdata, 1000) as $t) {
                            employee::insertOrIgnore($t);
                        }


                        /*   $empdata = $this->processPapersEmpFile($megration->path . DIRECTORY_SEPARATOR . $file, $request->ID_MEGRATION);
                       //dd( $empdata);
                        foreach (array_chunk($empdata, 1000) as $d) {
                            // Filter out records with existing MATRI values
                            $filteredData = array_filter($d, function ($employee) use ($existingMATRIs) {
                                return !in_array($employee['MATRI'], $existingMATRIs);
                            });

                            // Insert only new records
                            if (!empty($filteredData)) {
                              employee::insertOrIgnore($t);($filteredData);
                            }
                        }  */
                        //dd( $filteredData);

                    } elseif (str_contains($file, "PAVAR")) {
                        // dd(1);
                        //  use function processPavarFile to  to read excel file (in param file path)
                        // and return data[] ARRAY
                        $data = $this->processPavarFile($megration->path . DIRECTORY_SEPARATOR . $file, $request->ID_MEGRATION);

                        //  The data returned by processPapersFile is then inserted into the grants table
                        // in chunks of 1000 records to avoid memory overload.
                        foreach (array_chunk($data, 1000) as $t) {
                            //  dd($t);
                            grant::insert($t);
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
                return redirect()->route('admin-megration-salary-index')->with('success', $msg);
            } else {
                $msg = "الملف مفقود";
                return redirect()->route('admin-megration-salary-index')->withErrors(['error' => $msg]);
            }
        }
    }

    //function to read excel file (in param file path) and return data[] ARRAY
    private function processPapersFile($filePath, $ID_MEGRATION)
    {
        $header = null;
        $data = [];

        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($handle, 10000, ';')) !== false) {
                if (!$header) {
                    $header = $row;
                    //dd($header);
                } else {
                    if ($row[16] == 0) {
                        $data[] = [
                            'MATRI' =>  strlen($row[0]) == 7 ? "000" . $row[0] : $row[0],
                            'CODEFONC' => $row[12],
                            'AFFECT' => $row[25],
                            'SITFAM' => $row[9],
                            'ENF10' => $row[10],
                            'CATEG' => $row[27],
                            'ECH' => $row[29],
                            'ADM' => $row[2],
                            'TOTGAIN' => $row[38],
                            'NETPAI' =>  !empty($row[41]) ? $row[41] : null,
                            'NBRTRAV' => $row[49],
                            'BRUTSS' =>  !empty($row[35]) ? $row[35] : null,
                            'RETSS' =>  !empty($row[36]) ? $row[36] : null,
                            'NUMCPT' => $row[23],
                            'PARTSS' =>  !empty($row[58]) ? $row[58] : null,
                            'CLECPT' => $row[61],
                            // Assuming 'ID_MEGRATION_RA' is not included in the CSV file
                            // You can remove this line if ID_MEGRATION_RA is not needed from CSV
                            'ID_MEGRATION' => $ID_MEGRATION,
                        ];
                    }
                }
            }
            fclose($handle);
        }
        return $data;
    }


    //function to read excel file (in param file path) and return data[] ARRAY
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

    //function to read excel file (in param file path) and return data[] ARRAY
    private function processPavarFile($filePath, $ID_MEGRATION)
    {
        $header = null;
        $data = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($handle, 10000, ';')) !== false) {

                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = [
                        'MATRI' => strlen($row[0]) == 7 ? "000" . $row[0] : $row[0],
                        'IND' => $row[3],
                        'ADM' => $row[4],
                        'BASENBR' => !empty($row[5]) ? (int)$row[5] : null,
                        'TAUX' => !empty($row[6]) ? (float)$row[6] : null,
                        'MONTANT' => !empty($row[7]) ? (float)$row[7] : null,
                        'MFIX' => !empty($row[8]) ? (float)$row[8] : null,
                        'ID_MEGRATION' => $ID_MEGRATION,
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
        $megration = megration::find($request->ID_MEGRATION);
        $megration->delete();
        File::deleteDirectory($megration->path);
        emp_megration::where("ID_MEGRATION", $request->ID_MEGRATION)->delete();
        grant::where("ID_MEGRATION", $request->ID_MEGRATION)->delete();
        DB::commit();
        return redirect()->back();
    }



    public function stat($ID_MEGRATION)
    {  //////////////////// with calculate every time  ///////////////////////////////////////
        /*    $stat_megration = emp_megration::join('megrations', 'emp_megrations.ID_MEGRATION', '=', 'megrations.ID_MEGRATION')
            ->where('emp_megrations.ID_MEGRATION', $ID_MEGRATION)
            ->select(
                'megrations.ID_MEGRATION',
                'megrations.MONTH',
                'megrations.YEAR' ,
                'megrations.LOT'
            )
            ->selectRaw('
                    COUNT(emp_megrations.MATRI) as nbr_employees, 
                    SUM(emp_megrations.NETPAI) as total_NETPAI, 
                    SUM(emp_megrations.TOTGAIN) as total_TOTGAIN, 
                    SUM(emp_megrations.RETSS) as total_RETSS, 
                    SUM(emp_megrations.PARTSS) as total_PARTSS
                ')
            ->groupBy('megrations.ID_MEGRATION', 'megrations.MONTH', 'megrations.YEAR' ,'megrations.LOT')
            ->first();
              $megration = megration::where('ID_MEGRATION', $ID_MEGRATION);
            $megration->nbr_employees=$stat_megration->nbr_employees;
            $megration->total_NETPAI=$stat_megration->total_NETPAI;
            $megration->total_TOTGAIN=$stat_megration->total_TOTGAIN;
            $megration->total_RETSS=$stat_megration->total_RETSS;
            $megration->total_PARTSS=$stat_megration->total_PARTSS;
            $megration->save();  
        return response()->json($stat_megration); */

        //////////////////// with table stat_emp_megrations /////////////////////////////
        /*      // Check if the statistics already exist in the stat_emp_megrations table
    $stat_record = stat_emp_megration::where('ID_MEGRATION', $ID_MEGRATION)->first();
    if ($stat_record) {
        // Return the saved statistics
        return response()->json($stat_record);
    }
    // Calculate the statistics if not already saved
    $stat_megration = emp_megration::join('megrations', 'emp_megrations.ID_MEGRATION', '=', 'megrations.ID_MEGRATION')
        ->where('emp_megrations.ID_MEGRATION', $ID_MEGRATION)
        ->select(
            'megrations.ID_MEGRATION',
            'megrations.MONTH',
            'megrations.YEAR',
            'megrations.LOT'
        )
        ->selectRaw('
            COUNT(emp_megrations.MATRI) as nbr_employees, 
            SUM(emp_megrations.NETPAI) as total_NETPAI, 
            SUM(emp_megrations.TOTGAIN) as total_TOTGAIN, 
            SUM(emp_megrations.RETSS) as total_RETSS, 
            SUM(emp_megrations.PARTSS) as total_PARTSS
        ')
        ->groupBy('megrations.ID_MEGRATION', 'megrations.MONTH', 'megrations.YEAR', 'megrations.LOT')
        ->first();
    if ($stat_megration) {
        // Save the statistics in the stat_emp_megrations table
        $stat_record = stat_emp_megration::create([
            'ID_MEGRATION' => $stat_megration->ID_MEGRATION,
            'MONTH' => $stat_megration->MONTH,
            'YEAR' => $stat_megration->YEAR,
            'LOT' => $stat_megration->LOT, 
            'nbr_employees' => $stat_megration->nbr_employees,
            'total_NETPAI' => $stat_megration->total_NETPAI,
            'total_TOTGAIN' => $stat_megration->total_TOTGAIN,
            'total_RETSS' => $stat_megration->total_RETSS,
            'total_PARTSS' => $stat_megration->total_PARTSS,
        ]);
    }
    // Return the saved statistics
    return response()->json($stat_record); */

        //////////////////// with table megrations ///////////////////////////////////
        // Check if the statistics already exist in the megration table
        $megration = megration::where('ID_MEGRATION', $ID_MEGRATION)->first();

        // If the statistics are already saved, return them
        if ($megration && $megration->nbr_employees !== null) {
            return response()->json($megration);
        }

        // Calculate the statistics if not already saved
        $stat_megration = emp_megration::join('megrations', 'emp_megrations.ID_MEGRATION', '=', 'megrations.ID_MEGRATION')
            ->where('emp_megrations.ID_MEGRATION', $ID_MEGRATION)
            ->select(
                'megrations.ID_MEGRATION',
                'megrations.MONTH',
                'megrations.YEAR',
                'megrations.LOT'
            )
            ->selectRaw('
            COUNT(emp_megrations.MATRI) as nbr_employees, 
            SUM(emp_megrations.NETPAI) as total_NETPAI, 
            SUM(emp_megrations.TOTGAIN) as total_TOTGAIN, 
            SUM(emp_megrations.RETSS) as total_RETSS, 
            SUM(emp_megrations.PARTSS) as total_PARTSS
        ')
            ->groupBy('megrations.ID_MEGRATION', 'megrations.MONTH', 'megrations.YEAR', 'megrations.LOT')
            ->first();

        if ($stat_megration) {
            // Update the existing row with the calculated statistics
            $megration->update([
                'nbr_employees' => $stat_megration->nbr_employees,
                'total_NETPAI' => $stat_megration->total_NETPAI,
                'total_TOTGAIN' => $stat_megration->total_TOTGAIN,
                'total_RETSS' => $stat_megration->total_RETSS,
                'total_PARTSS' => $stat_megration->total_PARTSS,
            ]);
        }

        // Return the updated row
        return response()->json($megration);
    }
}
