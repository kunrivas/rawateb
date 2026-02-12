<?php

namespace App\Http\Controllers\Admin\Megrations;

use App\Models\employee;
use App\Models\emp_megration;
use App\Models\grant;
use App\Models\megration;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SalaryMegrationController extends Controller
{
    public const SALARY_MEGRATION_FOLDER = "megration/salary";

    public static function storagePath(): string
    {
        return app()->environment('production')
            ? '/var/www/html/rawateb/storage/app/private'
            : base_path('storage/app/private');
    }

    public function index()
    {
        $megrations = megration::orderBy("YEAR", "DESC")
            ->orderBy("MONTH", "DESC")
            ->paginate(10);
        return view('admin.megrations.salary.list', ["megrations" => $megrations]);
    }

    public function create()
    {
        return view('admin.megrations.salary.add');
    }

    public function store(Request $request)
    {
        try {
            if (megration::where("YEAR", $request->year)->where('Month', $request->month)->exists()) {
                return redirect()->back()->with("error", "هذه الحزمة موجودة مسبقًا");
            }

            if ($request->hasFile('megration')) {
                $path_megration = self::SALARY_MEGRATION_FOLDER . DIRECTORY_SEPARATOR . $request->year . DIRECTORY_SEPARATOR . $request->month;

                $unzipper  = new \ZipArchive();
                $file = $request->megration->store($path_megration);
                $unzipper->open(self::storagePath() . DIRECTORY_SEPARATOR . $file);
                $unzipper->extractTo(self::storagePath() . DIRECTORY_SEPARATOR . $path_megration . DIRECTORY_SEPARATOR . 'extracted');
                $unzipper->close();

                $newMegration = new megration();
                $newMegration->Month = $request->month;
                $newMegration->YEAR = $request->year;
                $newMegration->LOT = $request->LOT;
                $newMegration->path = self::storagePath() . DIRECTORY_SEPARATOR . $path_megration . DIRECTORY_SEPARATOR . 'extracted';
                $newMegration->save();

                return redirect()->route("admin-megration-salary-index")->with("success", "تم إضافة الحزمة بنجاح");
            }

            return redirect()->back()->with("error", "حدث خطأ الرجاء التأكد من صحة البيانات");
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }


    public function run_megration(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $megration = megration::where("ID_MEGRATION", $request->ID_MEGRATION)->first();
        if (!$megration || $megration->STATUS != 0) {
            return back()->withErrors(['error' => 'هذه الحزمة تم تنفيذها مسبقًا أو غير موجودة']);
        }

        $megration->RUN = 1;
        $megration->save();

        if (!file_exists($megration->path)) {
            return back()->withErrors(['error' => 'مسار الملفات غير موجود']);
        }

        try {
            DB::beginTransaction();

            // 1️⃣ Temporary tables with utf8mb4
            DB::statement("
            CREATE TEMPORARY TABLE temp_employee_raw (
                MATRI VARCHAR(50) NULL,
                NOM VARCHAR(255) NULL,
                PRENOM VARCHAR(255) NULL,
                NOMA VARCHAR(255) NULL,
                PRENOMA VARCHAR(255) NULL,
                DATNAIS DATE NULL,
                DATENT DATE NULL,
                NUMSS VARCHAR(50) NULL,
                AFFECT VARCHAR(50) NULL,
                CODEFONC VARCHAR(50) NULL,
                ADM VARCHAR(10) NULL,
                SITFAM VARCHAR(10) NULL,
                CATEG VARCHAR(10) NULL,
                ECH VARCHAR(10) NULL,
                SITPAI VARCHAR(10) NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

            DB::statement("
            CREATE TEMPORARY TABLE temp_salary_raw (
                MATRI VARCHAR(50) NULL,
                CODEFONC VARCHAR(255) NULL,
                AFFECT VARCHAR(50) NULL,
                SITFAM VARCHAR(255) NULL,
                ENF10 VARCHAR(2) NULL,
                CATEG VARCHAR(255) NULL,
                ECH VARCHAR(255) NULL,
                ADM VARCHAR(255) NULL,
                TOTGAIN DECIMAL(14,2) NULL,
                NETPAI DECIMAL(14,2) NULL,
                NBRTRAV INT NULL,
                BRUTSS DECIMAL(14,2) NULL,
                RETSS DECIMAL(14,2) NULL,
                PARTSS DECIMAL(14,2) NULL,
                NUMCPT VARCHAR(50) NULL,
                CLECPT VARCHAR(2) NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

            DB::statement("
            CREATE TEMPORARY TABLE temp_grant_raw (
                MATRI VARCHAR(50) NULL,
                IND VARCHAR(255) NULL,
                ADM VARCHAR(255) NULL,
                BASENBR DECIMAL(14,2) NULL,
                TAUX DECIMAL(14,2) NULL,
                MONTANT DECIMAL(14,2) NULL,
                MFIX DECIMAL(14,2) NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

            // 2️⃣ Load CSV files
            $files = scandir($megration->path);

            //dd( $files);
            foreach ($files as $file) {
                $fullPath = $megration->path . DIRECTORY_SEPARATOR . $file;
                if (str_contains($file, 'PAPERS')) {
                    $this->loadEmployees($fullPath);
                    $this->loadSalaryPapers($fullPath);
                } elseif (str_contains($file, 'PAVAR')) {
                    $this->loadSalaryPavar($fullPath);
                    //    dd(DB::select("SELECT COUNT(*) c FROM temp_grant_raw"));
                }
            }

            // 3️⃣ Insert / Update employees
            DB::statement("
           INSERT INTO employees (
    MATRI, NOM, PRENOM, NOMA, PRENOMA, DATNAIS, DATENT, NUMSS, AFFECT, CODEFONC, ADM, SITFAM, CATEG, ECH, SITPAI
)
SELECT 
    MATRI,
    SUBSTRING(NOM,1,20),
    SUBSTRING(PRENOM,1,20),
    SUBSTRING(NOMA,1,20),
    SUBSTRING(PRENOMA,1,20),
    NULLIF(DATNAIS,'0000-00-00'),
    NULLIF(DATENT,'0000-00-00'),
    NUMSS,
     CASE WHEN AFFECT REGEXP '^[0-9]+$' THEN CAST(AFFECT AS UNSIGNED) ELSE 0 END,
    SUBSTRING(CODEFONC,1,6),
    LEFT(ADM,1),
    LEFT(SITFAM,3),
    LEFT(CATEG,2),
    LEFT(ECH,2),
    IF(TRIM(SITPAI) = '' OR SITPAI IS NULL, 0, LEFT(TRIM(SITPAI), 1))
FROM temp_employee_raw
ON DUPLICATE KEY UPDATE
    NOM = VALUES(NOM),
    PRENOM = VALUES(PRENOM),
    NOMA = VALUES(NOMA),
    PRENOMA = VALUES(PRENOMA),
    SITPAI = VALUES(SITPAI),
    DATNAIS = CASE WHEN VALUES(SITPAI) = 0 THEN VALUES(DATNAIS) ELSE DATNAIS END,
    DATENT = CASE WHEN VALUES(SITPAI) = 0 THEN VALUES(DATENT) ELSE DATENT END,
    NUMSS = CASE WHEN VALUES(SITPAI) = 0 THEN VALUES(NUMSS) ELSE NUMSS END,
    AFFECT = CASE WHEN VALUES(SITPAI) = 0 THEN VALUES(AFFECT) ELSE AFFECT END,
    CODEFONC = CASE WHEN VALUES(SITPAI) = 0 THEN VALUES(CODEFONC) ELSE CODEFONC END,
    ADM = CASE WHEN VALUES(SITPAI) = 0 THEN VALUES(ADM) ELSE ADM END,
    SITFAM = CASE WHEN VALUES(SITPAI) = 0 THEN VALUES(SITFAM) ELSE SITFAM END,
    CATEG = CASE WHEN VALUES(SITPAI) = 0 THEN VALUES(CATEG) ELSE CATEG END,
    ECH = CASE WHEN VALUES(SITPAI) = 0 THEN VALUES(ECH) ELSE ECH END;
        ");

            // 4️⃣ Insert into emp_megrations
            DB::statement("
            INSERT INTO emp_megrations (
                MATRI, CODEFONC, AFFECT, SITFAM, ENF10, CATEG, ECH, ADM, TOTGAIN, NETPAI, 
                NBRTRAV, BRUTSS, RETSS, NUMCPT, PARTSS, CLECPT, ID_MEGRATION
            )
            SELECT 
                  MATRI,
    LEFT(CODEFONC,6),
    CASE 
        WHEN TRIM(AFFECT) REGEXP '^[0-9]+$' THEN CAST(TRIM(AFFECT) AS UNSIGNED) 
        ELSE 0 
    END,
    LEFT(SITFAM,3),
    ENF10,
    LEFT(CATEG,2),
    LEFT(ECH,2),
    LEFT(ADM,1),
    TOTGAIN,
    NETPAI,
    NBRTRAV,
    BRUTSS,
    RETSS,
    NUMCPT,
    PARTSS,
    CLECPT,
                {$megration->ID_MEGRATION}
            FROM temp_salary_raw
        ");

            // 5️⃣ Insert grants
            DB::statement("
            INSERT INTO grants_new (
                MATRI, IND, ADM, BASENBR, TAUX, MONTANT, MFIX, ID_MEGRATION
            )
            SELECT 
                 MATRI,
    LEFT(IND,3),
    LEFT(ADM,1),
    BASENBR,
    TAUX,
    MONTANT,
    MFIX,
                {$megration->ID_MEGRATION}
            FROM temp_grant_raw
        ");

            DB::commit();

            $megration->RUN = 0;
            $megration->STATUS = 1;
            $megration->ACTIVE = 1;
            $megration->save();

            return redirect()->route('admin-megration-salary-index')->with('success', 'تم تحديث الرواتب بنجاح');
        } catch (\Throwable $e) {
            DB::rollBack();
            $megration->RUN = 0;
            $megration->save();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    // باقي الدوال loadEmployees, loadSalaryPapers, loadSalaryPavar تبقى كما هي مع CHARACTER SET utf8mb4

    private function loadEmployees($filePath)
    {
        $absolutePath = realpath($filePath);
        $file = fopen($absolutePath, 'r');
        
        // Skip header
        fgets($file);

        $batch = [];
        while (($line = fgets($file)) !== false) {
            // Convert encoding if needed
            if (!mb_check_encoding($line, 'UTF-8')) {
                $line = @iconv('CP1256', 'UTF-8//IGNORE', $line) ?:
                        @iconv('ISO-8859-6', 'UTF-8//IGNORE', $line) ?:
                        @iconv('Windows-1256', 'UTF-8//IGNORE', $line) ?: $line;
            }

            $data = str_getcsv($line, ';');
            if (count($data) < 30) continue;

            $batch[] = [
                'MATRI'    => (strlen($data[0]) == 7) ? '000' . $data[0] : $data[0],
                'NOM'      => $data[3],
                'PRENOM'   => $data[4],
                'NOMA'     => $data[5],
                'PRENOMA'  => $data[6],
                'DATNAIS'  => ($data[8] == '0000-00-00' || empty($data[8])) ? null : $data[8],
                'DATENT'   => ($data[13] == '0000-00-00' || empty($data[13])) ? null : $data[13],
                'NUMSS'    => $data[18],
                'AFFECT'   => preg_match('/^[0-9]+$/', $data[25]) ? (int)$data[25] : 0,
                'CODEFONC' => $data[12],
                'ADM'      => $data[2],
                'SITFAM'   => $data[9],
                'CATEG'    => $data[27],
                'ECH'      => $data[29],
                'SITPAI'   => $data[16] ?? 0,
            ];

            if (count($batch) >= 500) {
                DB::table('temp_employee_raw')->insert($batch);
                $batch = [];
            }
        }
        if (!empty($batch)) {
            DB::table('temp_employee_raw')->insert($batch);
        }
        fclose($file);
    }

    private function loadSalaryPapers($filePath)
    {
        $absolutePath = realpath($filePath);
        $file = fopen($absolutePath, 'r');
        fgets($file);

        $batch = [];
        while (($line = fgets($file)) !== false) {
            $data = str_getcsv($line, ';');
            if (count($data) < 62) continue;

            $batch[] = [
                'MATRI'    => (strlen($data[0]) == 7) ? '000' . $data[0] : $data[0],
                'CODEFONC' => $data[12],
                'AFFECT'   => $data[25],
                'SITFAM'   => $data[9],
                'ENF10'    => $data[10],
                'CATEG'    => $data[27],
                'ECH'      => $data[29],
                'ADM'      => $data[2],
                'TOTGAIN'  => empty($data[38]) ? 0 : (float)$data[38],
                'NETPAI'   => empty($data[41]) ? 0 : (float)$data[41],
                'NBRTRAV'  => (int)$data[49],
                'BRUTSS'   => empty($data[35]) ? 0 : (float)$data[35],
                'RETSS'    => empty($data[36]) ? 0 : (float)$data[36],
                'NUMCPT'   => $data[23],
                'PARTSS'   => empty($data[58]) ? 0 : (float)$data[58],
                'CLECPT'   => $data[61] ?? '',
            ];

            if (count($batch) >= 500) {
                DB::table('temp_salary_raw')->insert($batch);
                $batch = [];
            }
        }
        if (!empty($batch)) {
            DB::table('temp_salary_raw')->insert($batch);
        }
        fclose($file);
    }

    private function loadSalaryPavar($filePath)
    {
        $absolutePath = realpath($filePath);
        $file = fopen($absolutePath, 'r');
        fgets($file);

        $batch = [];
        while (($line = fgets($file)) !== false) {
            $data = str_getcsv($line, ';');
            if (count($data) < 9) continue;

            $batch[] = [
                'MATRI'   => $data[0],
                'IND'     => $data[3],
                'ADM'     => $data[4],
                'BASENBR' => empty($data[5]) ? 0 : (float)$data[5],
                'TAUX'    => empty($data[6]) ? 0 : (float)$data[6],
                'MONTANT' => empty($data[7]) ? 0 : (float)$data[7],
                'MFIX'    => empty($data[8]) ? 0 : (float)$data[8],
            ];

            if (count($batch) >= 500) {
                DB::table('temp_grant_raw')->insert($batch);
                $batch = [];
            }
        }
        if (!empty($batch)) {
            DB::table('temp_grant_raw')->insert($batch);
        }
        fclose($file);
    }


    public function delete(Request $request)
    {
        DB::beginTransaction();
        $megration = megration::find($request->ID_MEGRATION);
        emp_megration::where("ID_MEGRATION", $request->ID_MEGRATION)->delete();
        grant::where("ID_MEGRATION", $request->ID_MEGRATION)->delete();
        File::deleteDirectory($megration->path);
        $megration->delete();
        DB::commit();
        return redirect()->back();
    }
}
