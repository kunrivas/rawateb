
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Director\TresorController;
use App\Http\Controllers\Director\DirectorAtsController;
use App\Http\Controllers\Director\DirectorGetwayController;
use App\Http\Controllers\Director\DirectorSalaryController;
use App\Http\Controllers\Director\DirectorMouvementController;
use App\Http\Controllers\Director\RendementReservationController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

//'role:director'
Route::group(['prefix' => 'director', 'middleware' => env("APP_ENV", "local") == "local" ? [] : []], function () {

    /**
     * rendement reservation
     */
    Route::get('/rendement/reservation', [RendementReservationController::class, 'index'])->name('director-rendements-reservation');
    Route::get('/rendement/reservation/view', [RendementReservationController::class, 'index'])->name('director-rendements-reservation-view');
    Route::post('/rendement/reservation/preprint', [RendementReservationController::class, 'print_init'])->name('director-rendements-reservation-pre-print');
    Route::post('/rendement/reservation/print', [RendementReservationController::class, 'print_final'])->name('director-rendements-reservation-print-final');
    Route::get('/rendement/reservation/{rendement_reservations_id}/employee/list', [RendementReservationController::class, 'reservationList'])->name("director-rendements-reservation-employee-list");
    Route::post('/rendement/reservation/{rendement_reservations_id}/employee/list', [RendementReservationController::class, 'reservationList'])->name("director-rendements-reservation-employee-list");
    Route::get('/rendement/reservation/{rendement_reservations_id}/employee/{MATRI}/delete', [RendementReservationController::class, 'delete'])->name("director-rendements-reservation-employee-delete");
    Route::get('/rendement/{rendement_reservations_id}/get-employee/{MATRI}', [RendementReservationController::class, 'getEmployee'])->name('director-get-employee');

    Route::post('/rendement/reservation/employee/add', [RendementReservationController::class, 'saveNew'])->name("director-rendements-reservation-employee-add");
     
    
    /**
     * tresor
     */

    Route::match(['get', 'post'], '/tresor/list', [TresorController::class, 'list'])
        ->name('director-tresor-list');
    Route::get('/tresor/{MATRI}/edit', [TresorController::class, 'show'])->name('director-tresor-edit');
    Route::post('/tresor/store', [TresorController::class, 'store'])->name('director-tresor-store');
    Route::get('/tresor/{MATRI}/delete', [TresorController::class, 'delete'])->name('director-tresor-delete');
    Route::get('/tresor/print', [TresorController::class, 'print'])->name('director-tresor-print');

    Route::get('/tresor/stat', [TresorController::class, 'stat'])->name('director-tresor-stat');
    Route::get('/tresor/establishment/{affect}/list', [TresorController::class, 'showByEstablishment'])
        ->name('director-tresor-establishment-list');
    Route::get('/tresor/sql', [TresorController::class, 'exportTresorToSQL'])->name('director-tresor-sql');
    Route::get('/tresor/excel', [TresorController::class, 'exportTresorToExcel'])->name('director-tresor-excel');



    Route::get('/', function () {
        return view('layouts.director');
    })->name("director-home");



    /*
    salary
    * */


    Route::match(['get', 'post'], '/salary/single', [DirectorSalaryController::class, 'index'])
        ->name('director-salary-single-employees');
    //salary month
    Route::get('/salary/single/{MATRI}/list', [DirectorSalaryController::class, 'salary_single_list'])->name('director-salary-single-list');
    Route::post('/salary/single/print', [DirectorSalaryController::class, 'salary_single_print'])->name('director-salary-single-print');

    /**
     *
     * absences
     */

    Route::get('/absence/reservation', [App\Http\Controllers\Director\DirectorAbsenceReservationController::class, 'index'])->name('director-absence-reservation');

    Route::get('/absence/reservation/{dir_absence_reservation_id}/employees/list', [App\Http\Controllers\Director\DirectorAbsenceReservationController::class, 'reservationList'])->name("director-absence-reservation-employees-list");
    Route::post('/absence/reservation/{dir_absence_reservation_id}/employees/list', [App\Http\Controllers\Director\DirectorAbsenceReservationController::class, 'reservationList'])->name("director-absence-reservation-employees-list");
    Route::get('/absence/reservation/{dir_absence_reservation_id}/print', [App\Http\Controllers\Director\DirectorAbsenceReservationController::class, 'dir_absence_reservation_print'])->name('director-absence-reservation-print');
    Route::get('/absence/reservation/{id}/cancel', [App\Http\Controllers\Director\DirectorAbsenceReservationController::class, 'destroy'])->name('director-absence-reservation-cancel');
    Route::get('/absence/reservation/get-employee/{MATRI}', [App\Http\Controllers\Director\DirectorAbsenceReservationController::class, 'getEmployee'])->name('director-get-employee');
    Route::post('/absence/reservation/insert-absence', [App\Http\Controllers\Director\DirectorAbsenceReservationController::class, 'insertAbsence'])->name('director-insert-absence');

    Route::get('/absence/single/{id}/print', [App\Http\Controllers\Director\DirectorAbsenceReservationController::class, 'absence_single_print'])->name('director-absence-single-print');

    /**
     * ats
     */
    /////////
    Route::match(['get', 'post'], '/ats/single', [DirectorAtsController::class, 'index'])
    ->name('director-ats-single-employees');
    Route::get('/ats/single/{MATRI}/list', [DirectorAtsController::class, 'ats_single_list'])->name('director-ats-single-list');
    Route::post('/ats/single/print', [DirectorAtsController::class, 'ats_single_print'])->name('director-ats-single-print');


     /**
     * mouvement
     */
    ///////ask////
    Route::match(['get', 'post'], '/mouvement/single', [DirectorMouvementController::class, 'index'])
        ->name('director-mouvement-single-employees');
    Route::get('/mouvement/single/{MATRI}/ask', [DirectorMouvementController::class, 'mouvement_single_ask'])->name('director-mouvement-single-ask');
    Route::post('/mouvement/single/confirm', [DirectorMouvementController::class, 'store'])->name('director-mouvement-single-confirm');
    /////in////////
    Route::get('/mouvement/single/in', [DirectorMouvementController::class, 'in_index'])->name('director-mouvement-single-in-employees');
    Route::get('/mouvement/single/in/{id}/validate', [DirectorMouvementController::class, 'edit'])->name('director-mouvement-single-in-validate');
    /////out/////////
    Route::get('/mouvement/single/out', [DirectorMouvementController::class, 'out_index'])->name('director-mouvement-single-out-employees');
    //////////////cancel in and out////////////////////////////////
    Route::get('/mouvement/single/{id}/cancel', [DirectorMouvementController::class, 'destroy'])->name('director-mouvement-single-cancel');





});

Route::post('director/getway', [DirectorGetwayController::class, 'login'])->name('director-getway-login')->withoutMiddleware([VerifyCsrfToken::class]);
Route::get('director/getway/logout', [DirectorGetwayController::class, 'logout'])->name('director-getway-logout')->withoutMiddleware([VerifyCsrfToken::class]);
