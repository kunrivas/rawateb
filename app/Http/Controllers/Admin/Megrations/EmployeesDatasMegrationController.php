<?php

namespace App\Http\Controllers\Admin\Megrations;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ed_megration;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\employee;

class EmployeesDatasMegrationController extends Controller
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

    // emplyees-datas Megration folder path
    public const EMPLOYEES_DATAS_MEGRATION_FOLDER = "megration/emplyeesDatas";


    public function index()
    {
        $megrations = ed_megration::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.megrations..employees_datas.list', ["megrations" => $megrations]);
    }


    public function create()
    {
        return view('admin.megrations.employees_datas.add');
    }


    public function store(Request $request)
    {
        try {
            /* 
        if (megration::where("YEAR", $request->year)->where('Month', $request->month)->exists()) {
            return redirect()->back()->with("error", "هذه الحزمة موجودة مسبقًا");
        }
        */



            if ($request->hasFile('megration')) {
                $path_megration = EmployeesDatasMegrationController::EMPLOYEES_DATAS_MEGRATION_FOLDER . DIRECTORY_SEPARATOR . $request->year . DIRECTORY_SEPARATOR . $request->month;

                $unzipper  = new \ZipArchive();
                $file = $request->megration->store($path_megration);
                $unzipper->open(EmployeesDatasMegrationController::storagePath() . DIRECTORY_SEPARATOR . $file);
                $st = $unzipper->extractTo(EmployeesDatasMegrationController::storagePath() . DIRECTORY_SEPARATOR . $path_megration . DIRECTORY_SEPARATOR . 'extracted');
                $unzipper->close();
                //   dd(EmployeesDatasMegrationController::storagePath() . DIRECTORY_SEPARATOR . $path_megration . DIRECTORY_SEPARATOR . 'extracted');
                $newMegration = new ed_megration;
                $newMegration->Month = $request->month;
                $newMegration->YEAR = $request->year;
                $newMegration->LOT = $request->LOT;
                $newMegration->path = EmployeesDatasMegrationController::storagePath() . DIRECTORY_SEPARATOR . $path_megration . DIRECTORY_SEPARATOR . 'extracted';
                $newMegration->save();
                return redirect()->route("admin-megration-employees-datas-index")
                    ->with("success", "تم إضافة الحزمة بنجاح");
            }

            // return redirect()->back()->with("error", "حدث خطأ الرجاء التأكد من صحة البيانات");
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }


    //run megration with laravel php
    // run_megration — optimized, safe bulk update
    // run_megration — robust single-PDO version
  public function run_megration(Request $request)
{
    set_time_limit(0);
    ini_set('memory_limit', '-1');

    $megration = ed_megration::where("ID_MEGRATION", $request->ID_MEGRATION)->first();

    if (!$megration || $megration->STATUS != 0) {
        return back()->withErrors(['error' => 'هذه الحزمة تم تنفيذها مسبقًا أو غير موجودة ❌']);
    }

    $megration->RUN = 1;
    $megration->save();

    mb_internal_encoding("UTF-8");

    if (!file_exists($megration->path)) {
        return back()->withErrors(['error' => 'مسار الملفات غير موجود ❌']);
    }

    try {
        DB::beginTransaction();

        // Phase 1: Create RAW table
        DB::statement("
            CREATE TEMPORARY TABLE temp_employees_raw (
                MATRI VARCHAR(50) NULL,
                CODEFONC VARCHAR(255) NULL,
                ADM VARCHAR(255) NULL,
                SITFAM VARCHAR(255) NULL,
                CATEG VARCHAR(255) NULL,
                ECH VARCHAR(255) NULL,
                SITPAI VARCHAR(255) NULL
            ) ENGINE=InnoDB
        ");

        // Load all files
        $files = scandir($megration->path);
        foreach ($files as $file) {
            if (str_contains($file, 'PAPERS')) {
                $this->loadEmployeeFileToTempRaw($megration->path . DIRECTORY_SEPARATOR . $file);
            }
        }

        // Phase 2 — Create validated deduplicated table
        DB::statement("
            CREATE TEMPORARY TABLE temp_employees_update AS
            SELECT 
                LPAD(MATRI, 10, '0') AS MATRI,
                CODEFONC,
                ADM,
                SITFAM,
                CATEG,
                ECH,
                SITPAI
            FROM (
                SELECT 
                    TRIM(MATRI) AS MATRI,
                    LEFT(TRIM(CODEFONC), 6) AS CODEFONC,
                    LEFT(TRIM(ADM), 1) AS ADM,
                    LEFT(TRIM(SITFAM), 3) AS SITFAM,
                    LEFT(TRIM(CATEG), 2) AS CATEG,
                    LEFT(TRIM(ECH), 2) AS ECH,
                    IF(TRIM(SITPAI) = '' OR SITPAI IS NULL, 0, LEFT(TRIM(SITPAI), 1)) AS SITPAI
                FROM temp_employees_raw
            ) AS t
            WHERE MATRI IS NOT NULL AND MATRI <> ''
            ORDER BY MATRI, SITPAI ASC
        ");

      //  DB::statement("ALTER TABLE temp_employees_update ADD PRIMARY KEY (MATRI)");

        // Phase 3 — Update employees
        DB::statement("
            UPDATE employees e
            JOIN temp_employees_update t ON e.MATRI = t.MATRI
            SET 
                -- SITPAI is always updated
                e.SITPAI = t.SITPAI,

                -- Other fields updated only if SITPAI = 0
                e.CODEFONC = CASE WHEN t.SITPAI = 0 THEN t.CODEFONC ELSE e.CODEFONC END,
                e.ADM      = CASE WHEN t.SITPAI = 0 THEN t.ADM      ELSE e.ADM END,
                e.SITFAM   = CASE WHEN t.SITPAI = 0 THEN t.SITFAM   ELSE e.SITFAM END,
                e.CATEG    = CASE WHEN t.SITPAI = 0 THEN t.CATEG    ELSE e.CATEG END,
                e.ECH      = CASE WHEN t.SITPAI = 0 THEN t.ECH      ELSE e.ECH END
        ");

        // Finalize
        DB::commit();

        $megration->RUN = 0;
        $megration->STATUS = 1;
        $megration->ACTIVE = 1;
        $megration->save();

        return redirect()->route("admin-megration-employees-datas-index")
            ->with('success', '✔ تم تحديث الموظفين بنجاح وبشكل صحيح حسب SITPAI');

    } catch (\Throwable $e) {
        DB::rollBack();
        $megration->RUN = 0;
        $megration->save();
        return back()->withErrors(['error' => $e->getMessage()]);
    }
}

private function loadEmployeeFileToTempRaw($filePath)
{
    $pdo = DB::connection()->getPdo();
    $absolutePath = realpath($filePath);

    if (!$absolutePath || !file_exists($absolutePath)) {
        throw new \Exception("❌ File not found: " . $filePath);
    }

    $sql = "
        LOAD DATA LOCAL INFILE '" . addslashes($absolutePath) . "'
        INTO TABLE temp_employees_raw
        CHARACTER SET utf8
        FIELDS TERMINATED BY ';'
        ENCLOSED BY '\"'
        LINES TERMINATED BY '\n'
        IGNORE 1 LINES
        (@MATRI, @col1, @ADM, @col3, @col4, @col5, @col6, @col7, @col8, @SITFAM, @col10,
         @col11, @CODEFONC, @col13, @col14, @col15, @SITPAI, @col17, @col18, @col19, @col20,
         @col21, @col22, @col23, @col24, @col25, @col26, @CATEG, @col28, @ECH)
        SET 
            MATRI = @MATRI,
            CODEFONC = @CODEFONC,
            ADM = @ADM,
            SITFAM = @SITFAM,
            CATEG = @CATEG,
            ECH = @ECH,
            SITPAI = @SITPAI
    ";

    $pdo->exec($sql);
}


    public function delete(Request $request)
    {
        DB::beginTransaction();
        $megration = ed_megration::find($request->ID_MEGRATION);
        $megration->delete();
        File::deleteDirectory($megration->path);
        DB::commit();
        return redirect()->back();
    }
}
