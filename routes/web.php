<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AtsController;
//use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\GetwayController;
use App\Http\Controllers\RappelController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TresorController;
use App\Http\Controllers\TamadresController;
use App\Http\Controllers\Google2FAController;
use App\Http\Controllers\MouvementController;
use App\Http\Controllers\RendementController;
use App\Http\Controllers\RappelRendementController;
use App\Http\Controllers\RappelReservationController;
use App\Http\Controllers\TamadresReservationController;
use App\Http\Controllers\RendementReservationController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

//to call admin and root routes
require_once "admin.php";
require_once "root.php";
require_once "absAdmin.php";
require_once "director.php";
//require_once "printer.php";


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//the default route

//Auth::routes();

//Route::get('/home', [HomeController::class, 'index'])->name('home');

/**
 * salary single
 */
/*same function called by get and post method (has 2 names differents of route )
/(the get used in megration list blade) (post used in select adms in self blade)*/

Route::group(['prefix' => '', 'middleware' => env("APP_ENV", "local") == "local" ? [] : ['auth']], function () {

    /*  //the routes of two-factor by email
    //this for affiche the two factor blade
    Route::get('/two-factor', [\App\Http\Controllers\TwoFactorController::class, 'index'])->name('twoFactor.index');
    //this for pass the two factor blade to home
    Route::post('/two-factor', [\App\Http\Controllers\TwoFactorController::class, 'store'])->name('twoFactor.store');
    Route::post('/two-factor/resend', [\App\Http\Controllers\TwoFactorController::class, 'resend'])->name('twoFactor.resend');

 */
    //the routes of Google2F two-factor
    // Google 2FA Setup routes.
    Route::get('/2fa/setup', [Google2FAController::class, 'showSetupForm'])->name('google2fa.setup');
    Route::post('/2fa/enable', [Google2FAController::class, 'enable2fa'])->name('google2fa.enable');
    Route::post('/2fa/disable', [Google2FAController::class, 'disable2fa'])->name('google2fa.disable');
    // 2FA Verification routes during login.
    Route::get('/2fa/verify', [Google2FAController::class, 'showVerifyForm'])->name('google2fa.verify');
    Route::post('/2fa/verify', [Google2FAController::class, 'verify2fa'])->name('google2fa.verify.post');


    Route::get('/', function () {
        return view('layouts/index');
    })->name("index");

    Route::match(['get', 'post'], '/salary/single', [SalaryController::class, 'index'])
        ->name('salary-single-employees');
    //salary month
    Route::get('/salary/single/{MATRI}/list', [SalaryController::class, 'salary_single_list'])->name('salary-single-list');
    Route::post('/salary/single/print', [SalaryController::class, 'salary_single_print'])->name('salary-single-print');
    //salary year
    Route::get('/salary/single/year/{MATRI}/list', [SalaryController::class, 'salary_single_year_list'])->name('salary-single-year-list');
    Route::post('/salary/single/year/print', [SalaryController::class, 'salary_single_year_print'])->name('salary-single-year-print');
    //
    /**
     * salary global
     */
    Route::get('/salary/global/list', [SalaryController::class, 'salary_global_megration_list'])->name('salary-global-megration-list');
    /*same function called by get and post method (has 2 names differents of route )
    /(the get used in megration list blade) (post used in select adms in self blade)*/
    Route::get('/salary/global/{ID_MEGRATION}/view', [SalaryController::class, 'salary_global_view'])
        ->name('salary-global-view-get');
    Route::post('/salary/global/{ID_MEGRATION}/view', [SalaryController::class, 'salary_global_view'])
        ->name('salary-global-view-post');
    Route::post('/salary/global/print', [SalaryController::class, 'salary_global_print'])->name('salary-global-print');
    Route::post('/salary/single/global/print', [SalaryController::class, 'salary_single_global_print'])->name('salary-single-global-print');
    ///////// rappel
     //global
    Route::get('/rappel/global/list', [RappelController::class, 'rappel_global_list'])->name('rappel-global-list');
    Route::post('/rappel/global/print', [RappelController::class, 'rappel_global_print'])->name('rappel-global-print');
   //single
    Route::match(['get', 'post'], '/rappel/single', [RappelController::class, 'index'])
        ->name('rappel-single-employees');
    Route::get('/rappel/{MATRI}/list', [RappelController::class, 'rappel_list'])->name('rappel-single-list');
    Route::post('/rappel/print', [RappelController::class, 'rappel_print'])->name('rappel-single-print');
   

    /**
     * rendement
     */
    ///////// single
    Route::match(['get', 'post'], '/rendement/single', [RendementController::class, 'index'])
        ->name('rendement-single-employees');
    Route::get('/rendement/single/{MATRI}/list', [RendementController::class, 'rendement_single_list'])->name('rendement-single-list');
    Route::post('/rendement/single/print', [RendementController::class, 'rendement_single_print'])->name('rendement-single-print');
    ///////// global
    Route::get('/rendement/global/list', [RendementController::class, 'rendement_global_megration_list'])->name('rendement-global-megration-list');
    Route::post('/rendement/global/print', [RendementController::class, 'rendement_global_print'])->name('rendement-global-print');
    /**
     * rappel_rendement
     */
    /////////
    Route::match(['get', 'post'], '/rappel-rendement/single', [RappelRendementController::class, 'index'])
        ->name('rappel-rendement-single-employees');
    Route::get('/rappel-rendement/single/{MATRI}/list', [RappelRendementController::class, 'rappel_rendement_list'])->name('rappel-rendement-single-list');
    Route::post('/rappel-rendement/single/print', [RappelRendementController::class, 'rappel_rendement_print'])->name('rappel-rendementt-single-print');

    /**
     * tamadres
     */
    /////////
    ///////// single
    Route::match(['get', 'post'], '/tamadres/single', [TamadresController::class, 'index'])
        ->name('tamadres-single-employees');
    Route::get('/tamadres/single/{MATRI}/list', [TamadresController::class, 'tamadres_single_list'])->name('tamadres-single-list');
    Route::post('/tamadres/single/print', [TamadresController::class, 'tamadres_single_print'])->name('tamadres-single-print');
    ///////// global
    Route::get('/tamadres/global/list', [TamadresController::class, 'tamadres_global_megration_list'])->name('tamadres-global-megration-list');
    Route::post('/tamadres/global/print', [TamadresController::class, 'tamadres_global_print'])->name('tamadres-global-print');

    /**
     * ats
     */
    /////////
    Route::match(['get', 'post'], '/ats/single', [AtsController::class, 'index'])
        ->name('ats-single-employees');
    Route::get('/ats/single/{MATRI}/list', [AtsController::class, 'ats_single_list'])->name('ats-single-list');
    Route::post('/ats/single/print', [AtsController::class, 'ats_single_print'])->name('ats-single-print');

    /**
     * mouvement
     */
    ///////ask////
    Route::match(['get', 'post'], '/mouvement/single', [MouvementController::class, 'index'])
        ->name('mouvement-single-employees');
    Route::get('/mouvement/single/{MATRI}/ask', [MouvementController::class, 'mouvement_single_ask'])->name('mouvement-single-ask');
    Route::post('/mouvement/single/confirm', [MouvementController::class, 'store'])->name('mouvement-single-confirm');
    /////in////////
    Route::get('/mouvement/single/in', [MouvementController::class, 'in_index'])->name('mouvement-single-in-employees');
    Route::get('/mouvement/single/in/{id}/validate', [MouvementController::class, 'edit'])->name('mouvement-single-in-validate');
    /////out/////////
    Route::get('/mouvement/single/out', [MouvementController::class, 'out_index'])->name('mouvement-single-out-employees');
    //////////////cancel in and out////////////////////////////////
    Route::get('/mouvement/single/{id}/cancel', [MouvementController::class, 'destroy'])->name('mouvement-single-cancel');
    ////release/////
    Route::match(['get', 'post'], '/mouvement/employees-list/release', [MouvementController::class, 'employees_list_release'])->name('mouvement-employees-list-release');
    Route::post('mouvement/employees/{id}/release', [MouvementController::class, 'release'])
        ->name('mouvement-employees-release');


    /**
     * settings employees
     */
    Route::match(['get', 'post'], '/settings/employee/list', [EmployeeController::class, 'list'])
        ->name('settings-employee-list');
    Route::get('/settings/employee/{MATRI}/edit', [EmployeeController::class, 'show'])->name('settings-employee-edit');
    Route::post('/settings/employee/store', [EmployeeController::class, 'store'])->name('settings-employee-store');
    Route::get('/settings/employee/{MATRI}/delete', [EmployeeController::class, 'delete'])->name('settings-employee-delete');

    /**
     * tresor
     */

    Route::match(['get', 'post'], '/tresor/list', [TresorController::class, 'list'])
        ->name('tresor-list');
    Route::get('/tresor/{MATRI}/edit', [TresorController::class, 'show'])->name('tresor-edit');
    Route::post('/tresor/store', [TresorController::class, 'store'])->name('tresor-store');
    Route::get('/tresor/{MATRI}/delete', [TresorController::class, 'delete'])->name('tresor-delete');
    Route::get('/tresor/print', [TresorController::class, 'print'])->name('tresor-print');


    /**
     * 
     * rendement reservation
     */
    Route::get('/rendement/reservation', [RendementReservationController::class, 'index'])->name('rendements-reservation');
    Route::get('/rendement/reservation/view', [RendementReservationController::class, 'index'])->name('rendements-reservation-view');
    Route::post('/rendement/reservation/preprint', [RendementReservationController::class, 'print_init'])->name('rendements-reservation-pre-print');
    Route::post('/rendement/reservation/print', [RendementReservationController::class, 'print_final'])->name('rendements-reservation-print-final');
    Route::get('/rendement/reservation/{rendement_reservations_id}/employee/list', [RendementReservationController::class, 'reservationList'])->name("rendements-reservation-employee-list");
    Route::post('/rendement/reservation/{rendement_reservations_id}/employee/list', [RendementReservationController::class, 'reservationList'])->name("rendements-reservation-employee-list");
    Route::post('/rendement/reservation/saveAll', [RendementReservationController::class, 'saveAll'])->name("rendements-reservation-save-all");
    Route::get('/rendement/reservation/{rendement_reservations_id}/employee/add/list', [RendementReservationController::class, 'addEmployeeList'])->name("rendements-reservation-employee-add-list");
    Route::post('/rendement/reservation/employee/add', [RendementReservationController::class, 'addEmployee'])->name("rendements-reservation-employee-add");
    Route::get('/rendement/reservation/{rendement_reservations_id}/employee/{MATRI}/delete', [RendementReservationController::class, 'delete'])->name("rendements-reservation-employee-delete");

    /**
     * rappel reservation
     */
    Route::get('/rappel/reservation', [RappelReservationController::class, 'index'])->name('rappel-reservation');
    Route::get('/rappel/reservation/{rappel_reservation_id}/employees/list', [RappelReservationController::class, 'reservationList'])->name("rappel-reservation-employees-list");
    Route::post('/rappel/reservation/{rappel_reservation_id}/employees/list', [RappelReservationController::class, 'reservationList'])->name("rappel-reservation-employees-list");
    Route::post('/rappel/reservation/print', [RappelReservationController::class, 'rappel_reservation_print'])->name('rappel-reservation-print');
    Route::get('/rappel/reservation/{id}/cancel', [RappelReservationController::class, 'destroy'])->name('rappel-reservation-cancel');
    Route::get('/rappel/reservation/get-employee/{MATRI}', [RappelReservationController::class, 'getEmployee'])->name('get-employee');
    Route::post('/rappel/reservation/insert-rappel', [RappelReservationController::class, 'insertRappel'])->name('insert-rappel');

    /**
     * tamadres reservation
     */
    Route::get('/tamadres/reservation', [TamadresReservationController::class, 'index'])->name('tamadres-reservation');
    Route::get('/tamadres/reservation/{tamadres_reservation_id}/employees/list', [TamadresReservationController::class, 'reservationList'])->name("tamadres_reservation-employees-list");
    Route::post('/tamadres/reservation/{tamadres_reservation_id}/employees/list', [TamadresReservationController::class, 'reservationList'])->name("tamadres_reservation-employees-list");
    Route::get('/tamadres/reservation/get-employee/{MATRI}', [TamadresReservationController::class, 'getEmployee'])->name('get-employee');
    Route::post('/tamadres/reservation/insert-tamadres', [TamadresReservationController::class, 'insertTamadres'])->name('insert-tamadres');
    Route::get('/tamadres/reservation/{id}/cancel', [TamadresReservationController::class, 'destroy'])->name('tamadres-reservation-cancel');
    Route::post('/tamadres/reservation/print', [TamadresReservationController::class, 'tamadres_reservation_print'])->name('tamadres-reservation-print');
});

//// getway
Route::get('/test', [GetwayController::class, 'test'])->name('getway-login')->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/getway', [GetwayController::class, 'login'])->name('getway-login')->withoutMiddleware([VerifyCsrfToken::class]);
Route::get('/getway/logout', [GetwayController::class, 'logout'])->name('getway-logout')->withoutMiddleware([VerifyCsrfToken::class]);
