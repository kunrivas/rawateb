
<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TresorController;
use App\Http\Controllers\Admin\EmployeeControlle;
use App\Http\Controllers\Admin\settings\FonctionController;

/* all the routes must pass this middleware
the middleware has test of env local doesnt work
 it work only on production env */


Route::group([
    'middleware' => ['web', 'auth', 'role:manager|printer']
], function () {

    /**
     *
     * megration salary
     *
     */
    Route::post('manager/megration/salary/delete', [App\Http\Controllers\Admin\Megrations\SalaryMegrationController::class, 'delete'])->name('admin-megration-salary-delete');
    Route::get('manager/megration/salary/create', [App\Http\Controllers\Admin\Megrations\SalaryMegrationController::class, 'create'])->name('admin-megration-salary-create');
    Route::post('manager/megration/salary/store', [App\Http\Controllers\Admin\Megrations\SalaryMegrationController::class, 'store'])->name('admin-megration-salary-store');
    Route::get('manager/megration/salary/', [App\Http\Controllers\Admin\Megrations\SalaryMegrationController::class, 'index'])->name('admin-megration-salary-index');
    Route::post('manager/megration/salary/run', [App\Http\Controllers\Admin\Megrations\SalaryMegrationController::class, 'run_megration'])->name('admin-megration-salary-run');
    Route::get('/manager/megration/salary/{ID_MEGRATION}/stat', [App\Http\Controllers\Admin\Megrations\SalaryMegrationController::class, 'stat'])->name('admin-megration-salary-stat');
    /**
     *
     * megration rappel
     *
     */


    Route::get('manager/megration/rappel/create', [App\Http\Controllers\Admin\Megrations\RappelMegrationController::class, 'create'])->name('admin-megration-rappel-create');
    Route::post('manager/megration/rappel/store', [App\Http\Controllers\Admin\Megrations\RappelMegrationController::class, 'store'])->name('admin-megration-rappel-store');
    Route::get('manager/megration/rappel/', [App\Http\Controllers\Admin\Megrations\RappelMegrationController::class, 'index'])->name('admin-megration-rappel-index');
    Route::post('manager/megration/rappel/run', [App\Http\Controllers\Admin\Megrations\RappelMegrationController::class, 'run_megration'])->name('admin-megration-rappel-run');
    Route::post('manager/megration/rappel/delete', [App\Http\Controllers\Admin\Megrations\RappelMegrationController::class, 'delete'])->name('admin-megration-rappel-delete');
    Route::get('/manager/megration/rappel/{ID_MEGRATION_RA}/stat', [App\Http\Controllers\Admin\Megrations\RappelMegrationController::class, 'stat'])->name('admin-megration-rappel-stat');
    /**
     *
     * megration rappel prime
     */


    Route::get('manager/megration/rappel-prime/create', [App\Http\Controllers\Admin\Megrations\RappelPrimeMegrationController::class, 'create'])->name('admin-megration-rappel-prime-create');
    Route::post('manager/megration/rappel-prime/store', [App\Http\Controllers\Admin\Megrations\RappelPrimeMegrationController::class, 'store'])->name('admin-megration-rappel-prime-store');
    Route::get('manager/megration/rappel-prime/', [App\Http\Controllers\Admin\Megrations\RappelPrimeMegrationController::class, 'index'])->name('admin-megration-rappel-prime-index');
    Route::post('manager/megration/rappel-prime/run', [App\Http\Controllers\Admin\Megrations\RappelPrimeMegrationController::class, 'run_megration'])->name('admin-megration-rappel-prime-run');
    Route::post('manager/megration/rappel-prime/delete', [App\Http\Controllers\Admin\Megrations\RappelPrimeMegrationController::class, 'delete'])->name('admin-megration-rappel-prime-delete');
    Route::get('/manager/megration/rappel-prime/{ID_MEGRATION_RA_RE}/stat', [App\Http\Controllers\Admin\Megrations\RappelPrimeMegrationController::class, 'stat'])->name('admin-megration-rappel-prime-stat');
    /**
     *
     * megration rendement
     */

    Route::get('manager/megration/rendement/create', [App\Http\Controllers\Admin\Megrations\RendementMegrationController::class, 'create'])->name('admin-megration-rendement-create');
    Route::post('manager/megration/rendement/store', [App\Http\Controllers\Admin\Megrations\RendementMegrationController::class, 'store'])->name('admin-megration-rendement-store');
    Route::get('manager/megration/rendement/', [App\Http\Controllers\Admin\Megrations\RendementMegrationController::class, 'index'])->name('admin-megration-rendement-index');
    Route::post('manager/megration/rendement/run', [App\Http\Controllers\Admin\Megrations\RendementMegrationController::class, 'run_re_megration'])->name('admin-megration-rendement-run');
    Route::post('manager/megration/rendement/delete', [App\Http\Controllers\Admin\Megrations\RendementMegrationController::class, 'delete'])->name('admin-megration-rendement-delete');
    Route::get('/manager/megration/rendement/{ID_MEGRATION_RE}/stat', [App\Http\Controllers\Admin\Megrations\RendementMegrationController::class, 'stat'])->name('admin-megration-rendement-stat');
    /**
     *
     * megration tamadres
     */

    Route::get('manager/megration/tamadres/delete', [App\Http\Controllers\Admin\Megrations\TamadresMegrationController::class, 'delete'])->name('admin-megration-tamadres-delete');
    Route::get('manager/megration/tamadres/create', [App\Http\Controllers\Admin\Megrations\TamadresMegrationController::class, 'create'])->name('admin-megration-tamadres-create');
    Route::post('manager/megration/tamadres/store', [App\Http\Controllers\Admin\Megrations\TamadresMegrationController::class, 'store'])->name('admin-megration-tamadres-store');
    Route::get('manager/megration/tamadres/', [App\Http\Controllers\Admin\Megrations\TamadresMegrationController::class, 'index'])->name('admin-megration-tamadres-index');
    Route::post('manager/megration/tamadres/run', [App\Http\Controllers\Admin\Megrations\TamadresMegrationController::class, 'run_ta_megration'])->name('admin-megration-tamadres-run');
    Route::get('/manager/megration/tamadres/{ID_MEGRATION_TA}/stat', [App\Http\Controllers\Admin\Megrations\TamadresMegrationController::class, 'stat'])->name('admin-megration-tamadres-stat');

    /**
     *
     * megration employees datas
     */

    Route::get('manager/megration/employees-datas/delete', [App\Http\Controllers\Admin\Megrations\EmployeesDatasMegrationController::class, 'delete'])->name('admin-megration-employees-datas-delete');
    Route::get('manager/megration/employees-datas/create', [App\Http\Controllers\Admin\Megrations\EmployeesDatasMegrationController::class, 'create'])->name('admin-megration-employees-datas-create');
    Route::post('manager/megration/employees-datas/store', [App\Http\Controllers\Admin\Megrations\EmployeesDatasMegrationController::class, 'store'])->name('admin-megration-employees-datas-store');
    Route::get('manager/megration/employees-datas/', [App\Http\Controllers\Admin\Megrations\EmployeesDatasMegrationController::class, 'index'])->name('admin-megration-employees-datas-index');
    Route::post('manager/megration/employees-datas/run', [App\Http\Controllers\Admin\Megrations\EmployeesDatasMegrationController::class, 'run_megration'])->name('admin-megration-employees-datas-run');
    // Route::get('/manager/megration/tamadres/{ID_MEGRATION_TA}/stat', [App\Http\Controllers\Admin\Megrations\TamadresMegrationController::class, 'stat'])->name('admin-megration-tamadres-stat'); 

    /**
     *
     *  rendement reservation
     */
    Route::get('manager/rendements', [App\Http\Controllers\Admin\AdminRendementReservationController::class, 'index'])->name('admin-rendements');
    Route::get('manager/rendements/create', [App\Http\Controllers\Admin\AdminRendementReservationController::class, 'create'])->name('admin-rendement-create');
    Route::post('manager/rendements/store', [App\Http\Controllers\Admin\AdminRendementReservationController::class, 'store'])->name('admin-rendement-store');
    Route::post('manager/rendements/delete/', [App\Http\Controllers\Admin\AdminRendementReservationController::class, 'destroy'])->name('admin-rendement-delete');
    Route::post('manager/rendements/status/', [App\Http\Controllers\Admin\AdminRendementReservationController::class, 'status'])->name('admin-rendement-status');
    Route::get('manager/rendements/{rendement_reservations_id}/establishments', [App\Http\Controllers\Admin\AdminRendementReservationController::class, 'establishmentList'])->name('admin-rendements-establishments');
    Route::post('manager/rendements/{rendement_reservations_id}/establishments', [App\Http\Controllers\Admin\AdminRendementReservationController::class, 'establishmentList'])->name('admin-rendements-establishments');
    Route::get('manager/rendements/{rendementStatistic_id}/establishment', [App\Http\Controllers\Admin\AdminRendementReservationController::class, 'reservationEstablishmentList'])->name('admin-rendements-establishments-employees');
    Route::post('manager/rendements/establishment/open', [App\Http\Controllers\Admin\AdminRendementReservationController::class, 'openToEstablishment'])->name('admin-rendements-establishments-open');
    Route::get('manager/rendements/{rendement_reservations_id}/in-establishment', [App\Http\Controllers\Admin\AdminRendementReservationController::class, 'in_establishmentList'])->name('admin-rendements-in-establishments');
    Route::post('manager/rendements/{rendement_reservations_id}/in-establishment', [App\Http\Controllers\Admin\AdminRendementReservationController::class, 'in_establishmentList'])->name('admin-rendements-in-establishments');
    Route::post('manager/rendements/export', [App\Http\Controllers\Admin\AdminRendementReservationController::class, 'exportRendement'])->name('admin-rendements-export');
    Route::post('manager/rendements/export-adm', [App\Http\Controllers\Admin\AdminRendementReservationController::class, 'exportADMRendement'])->name('admin-rendements-export-adm');
    /**
     *
     *  rapperl reservation
     */
    Route::get('manager/rappel/reservations', [App\Http\Controllers\Admin\AdminRappelReservationController::class, 'index'])->name('admin-rappels');
    Route::get('manager/rappel/reservations/create', [App\Http\Controllers\Admin\AdminRappelReservationController::class, 'create'])->name('admin-rappel-create');
    Route::post('manager/rappel/reservations/store', [App\Http\Controllers\Admin\AdminRappelReservationController::class, 'store'])->name('admin-rappel-store');
    Route::post('manager/rappel/reservations/delete/', [App\Http\Controllers\Admin\AdminRappelReservationController::class, 'destroy'])->name('admin-rappel-delete');
    Route::post('manager/rappel/reservations/status/', [App\Http\Controllers\Admin\AdminRappelReservationController::class, 'status'])->name('admin-rappel-status');

    Route::get('manager/rappel/{rappel_reservation_id}/establishments', [App\Http\Controllers\Admin\AdminRappelReservationController::class, 'establishmentList'])->name('admin-rappels-establishments');
    Route::post('manager/rappel/{rappel_reservation_id}/establishments', [App\Http\Controllers\Admin\AdminRappelReservationController::class, 'establishmentList'])->name('admin-rappels-establishments');
    Route::get('manager/rappel/{rappelStatistic_id}/establishment', [App\Http\Controllers\Admin\AdminRappelReservationController::class, 'reservationEstablishmentList'])->name('admin-rappels-establishments-employees');
    Route::get('manager/rappel/{rappel_reservation_id}/in-establishment', [App\Http\Controllers\Admin\AdminRappelReservationController::class, 'in_establishmentList'])->name('admin-rappels-in-establishments');
    Route::post('manager/rappel/{rappel_reservation_id}/in-establishment', [App\Http\Controllers\Admin\AdminRappelReservationController::class, 'in_establishmentList'])->name('admin-rappels-in-establishments');

    /**
     *
     *  tamadres reservation
     */
    Route::get('manager/tamadres/reservations', [App\Http\Controllers\Admin\AdminTamadresReservationController::class, 'index'])->name('admin-tamadres');
    Route::get('manager/tamadres/reservations/create', [App\Http\Controllers\Admin\AdminTamadresReservationController::class, 'create'])->name('admin-tamadres-create');
    Route::post('manager/tamadres/reservations/store', [App\Http\Controllers\Admin\AdminTamadresReservationController::class, 'store'])->name('admin-tamadres-store');
    Route::post('manager/tamadres/reservations/delete/', [App\Http\Controllers\Admin\AdminTamadresReservationController::class, 'destroy'])->name('admin-tamadres-delete');
    Route::post('manager/tamadres/reservations/status/', [App\Http\Controllers\Admin\AdminTamadresReservationController::class, 'status'])->name('admin-tamadres-status');

    Route::get('manager/tamadres/{tamadres_reservation_id}/establishments', [App\Http\Controllers\Admin\AdminTamadresReservationController::class, 'establishmentList'])->name('admin-tamadres-establishments');
    Route::post('manager/tamadres/{tamadres_reservation_id}/establishments', [App\Http\Controllers\Admin\AdminTamadresReservationController::class, 'establishmentList'])->name('admin-tamadres-establishments');
    Route::get('manager/tamadres/{tamadresStatistic_id}/establishment', [App\Http\Controllers\Admin\AdminTamadresReservationController::class, 'reservationEstablishmentList'])->name('admin-tamadres-establishments-employees');
    Route::get('manager/tamadres/{tamadres_reservation_id}/in-establishment', [App\Http\Controllers\Admin\AdminTamadresReservationController::class, 'in_establishmentList'])->name('admin-tamadres-in-establishments');
    Route::post('manager/tamadres/{tamadres_reservation_id}/in-establishment', [App\Http\Controllers\Admin\AdminTamadresReservationController::class, 'in_establishmentList'])->name('admin-tamadres-in-establishments');

    /**
     *
     *  absence reservation
     */
    Route::get('manager/absence/reservations', [App\Http\Controllers\Admin\AdminAbsenceReservationController::class, 'index'])->name('admin-absence');
    Route::get('manager/absence/reservations/create', [App\Http\Controllers\Admin\AdminAbsenceReservationController::class, 'create'])->name('admin-absence-create');
    Route::post('manager/absence/reservations/store', [App\Http\Controllers\Admin\AdminAbsenceReservationController::class, 'store'])->name('admin-absence-store');
    Route::post('manager/absence/reservations/status/', [App\Http\Controllers\Admin\AdminAbsenceReservationController::class, 'status'])->name('admin-absence-status');
    Route::post('manager/absence/reservations/delete/', [App\Http\Controllers\Admin\AdminAbsenceReservationController::class, 'destroy'])->name('admin-absence-delete');
    Route::get('manager/absence/reservation/{absence_reservation_id}/employees/list', [App\Http\Controllers\Admin\AdminAbsenceReservationController::class, 'reservationList'])->name("admin-absence-employees-list");
    Route::post('manager/absence/reservation/{absence_reservation_id}/employees/list', [App\Http\Controllers\Admin\AdminAbsenceReservationController::class, 'reservationList'])->name("admin-absence-employees-list");
    Route::get('manager/absence/reservation/{absence_reservation_id}/print', [App\Http\Controllers\Admin\AdminAbsenceReservationController::class, 'absence_reservation_print'])->name('admin-absence-print');
    Route::post('manager/absence/reservation/export/excel', [App\Http\Controllers\Admin\AdminAbsenceReservationController::class, 'absence_reservation_sql_export'])->name('admin-absence-export-excel');

    /**
     *
     *  dir absence reservation
     */
    Route::get('manager/dir-absence/reservations', [App\Http\Controllers\Admin\DirAdminAbsenceReservationController::class, 'index'])->name('dir-admin-absence');
    Route::get('manager/dir-absence/reservations/create', [App\Http\Controllers\Admin\DirAdminAbsenceReservationController::class, 'create'])->name('dir-admin-absence-create');
    Route::post('manager/dir-absence/reservations/store', [App\Http\Controllers\Admin\DirAdminAbsenceReservationController::class, 'store'])->name('dir-admin-absence-store');
    Route::post('manager/dir-absence/reservations/status/', [App\Http\Controllers\Admin\DirAdminAbsenceReservationController::class, 'status'])->name('dir-admin-absence-status');
    Route::post('manager/dir-absence/reservations/delete/', [App\Http\Controllers\Admin\DirAdminAbsenceReservationController::class, 'destroy'])->name('dir-admin-absence-delete');
    Route::get('manager/dir-absence/reservation/{absence_reservation_id}/employees/list', [App\Http\Controllers\Admin\DirAdminAbsenceReservationController::class, 'reservationList'])->name("dir-admin-absence-employees-list");
    Route::post('manager/dir-absence/reservation/{absence_reservation_id}/employees/list', [App\Http\Controllers\Admin\DirAdminAbsenceReservationController::class, 'reservationList'])->name("dir-admin-absence-employees-list");
    Route::get('manager/dir-absence/reservation/{absence_reservation_id}/print', [App\Http\Controllers\Admin\DirAdminAbsenceReservationController::class, 'absence_reservation_print'])->name('dir-admin-absence-print');
    Route::post('manager/dir-absence/reservation/export/excel', [App\Http\Controllers\Admin\DirAdminAbsenceReservationController::class, 'absence_reservation_sql_export'])->name('dir-admin-absence-export-excel');


    /**
     *
     * salary
     */

    Route::get('/manager/salary/single', [App\Http\Controllers\Admin\SalaryController::class, 'index'])->name('admin-salary-single-employees');
    Route::post('/manager/salary/single', [App\Http\Controllers\Admin\SalaryController::class, 'index'])->name('admin-salary-single-employees');
    //salary month
    Route::get('/manager/salary/single/{MATRI}/list', [App\Http\Controllers\Admin\SalaryController::class, 'salary_single_list'])->name('admin-salary-single-list');
    Route::post('/manager/salary/single/print', [App\Http\Controllers\Admin\SalaryController::class, 'salary_single_print'])->name('admin-salary-single-print');
    //salary year
    Route::get('/manager/salary/single/year/{MATRI}/list', [App\Http\Controllers\Admin\SalaryController::class, 'salary_single_year_list'])->name('admin-salary-single-year-list');
    Route::post('/manager/salary/single/year/print', [App\Http\Controllers\Admin\SalaryController::class, 'salary_single_year_print'])->name('admin-salary-single-year-print');

    /*
    * rappel
    */

    Route::get('/manager/rappel/single', [App\Http\Controllers\Admin\RappelController::class, 'index'])->name('admin-rappel-single-employees');
    Route::post('/manager/rappel/single', [App\Http\Controllers\Admin\RappelController::class, 'index'])->name('admin-rappel-single-employees');
    Route::get('/manager/rappel/{MATRI}/list', [App\Http\Controllers\Admin\RappelController::class, 'rappel_list'])->name('admin-rappel-single-list');
    Route::post('/manager/rappel/print', [App\Http\Controllers\Admin\RappelController::class, 'rappel_print'])->name('admin-rappel-single-print');

    /**
     * rendement
     */
    ///////// single

    Route::get('/manager/rendement/single', [App\Http\Controllers\Admin\RendementController::class, 'index'])->name('admin-rendement-single-employees');
    Route::post('/manager/rendement/single', [App\Http\Controllers\Admin\RendementController::class, 'index'])->name('admin-rendement-single-employees');
    Route::get('/manager/rendement/single/{MATRI}/list', [App\Http\Controllers\Admin\RendementController::class, 'rendement_single_list'])->name('admin-rendement-single-list');
    Route::post('/manager/rendement/single/print', [App\Http\Controllers\Admin\RendementController::class, 'rendement_single_print'])->name('admin-rendement-single-print');

    /**
     * rappel_rendement
     */
    /////////

    Route::get('/manager/rappel-rendement/single', [App\Http\Controllers\Admin\RappelRendementController::class, 'index'])->name('admin-rappel-rendement-single-employees');
    Route::post('/manager/rappel-rendement/single', [App\Http\Controllers\Admin\RappelRendementController::class, 'index'])->name('admin-rappel-rendement-single-employees');
    Route::get('/manager/rappel-rendement/single/{MATRI}/list', [App\Http\Controllers\Admin\RappelRendementController::class, 'rappel_rendement_list'])->name('admin-rappel-rendement-single-list');
    Route::post('/manager/rappel-rendement/single/print', [App\Http\Controllers\Admin\RappelRendementController::class, 'rappel_rendement_print'])->name('admin-rappel-rendement-single-print');

    /**
     * tamadres
     */
    /////////
    ///////// single


    Route::get('/manager/tamadres/single', [App\Http\Controllers\Admin\TamadresController::class, 'index'])->name('admin-tamadres-single-employees');
    Route::post('/manager/tamadres/single', [App\Http\Controllers\Admin\TamadresController::class, 'index'])->name('admin-tamadres-single-employees');
    Route::get('/manager/tamadres/single/{MATRI}/list', [App\Http\Controllers\Admin\TamadresController::class, 'tamadres_single_list'])->name('admin-tamadres-single-list');
    Route::post('/manager/tamadres/single/print', [App\Http\Controllers\Admin\TamadresController::class, 'tamadres_single_print'])->name('admin-tamadres-single-print');

    /**
     * deduction
     */
    /////////
    ///////// single


    Route::get('/manager/deduction/single', [App\Http\Controllers\Admin\DeductionController::class, 'index'])->name('admin-deduction-single-employees');
    Route::post('/manager/deduction/single', [App\Http\Controllers\Admin\DeductionController::class, 'index'])->name('admin-deduction-single-employees');
    Route::get('/manager/deduction/single/{MATRI}/list', [App\Http\Controllers\Admin\DeductionController::class, 'deduction_single_list'])->name('admin-deduction-single-list');
    Route::post('/manager/deduction/single/print', [App\Http\Controllers\Admin\DeductionController::class, 'deduction_single_print'])->name('admin-deduction-single-print');
    Route::post(
        '/manager/deduction/single/print/year',
        [App\Http\Controllers\Admin\DeductionController::class, 'deduction_single_year_print']
    )->name('admin-deduction-single-year-print');

    /**
     * ats
     */
    /////////
    Route::get('/manager/ats/single', [App\Http\Controllers\Admin\AtsController::class, 'index'])->name('admin-ats-single-employees');
    Route::post('/manager/ats/single', [App\Http\Controllers\Admin\AtsController::class, 'index'])->name('admin-ats-single-employees');
    Route::get('/manager/ats/single/{MATRI}/list', [App\Http\Controllers\Admin\AtsController::class, 'ats_single_list'])->name('admin-ats-single-list');
    Route::post('/manager/ats/single/print', [App\Http\Controllers\Admin\AtsController::class, 'ats_single_print'])->name('admin-ats-single-print');


    /**
     * mouvement
     *
     */
    /////out/////////

    Route::get('/manager/mouvement/single/out', [App\Http\Controllers\Admin\MouvementController::class, 'out_index'])->name('admin-mouvement-single-out-employees');
    Route::get('/manager/mouvement/single/in/{id}/validate', [App\Http\Controllers\Admin\MouvementController::class, 'edit'])->name('admin-mouvement-single-in-validate');
    Route::get('/manager/mouvement/single/{id}/cancel', [App\Http\Controllers\Admin\MouvementController::class, 'destroy'])->name('admin-mouvement-single-cancel');
    Route::get('/manager/mouvement/single/print_list', [App\Http\Controllers\Admin\MouvementController::class, 'print_list'])->name('admin-mouvement-single-print-list');
    Route::post('/manager/mouvement/single/print_list', [App\Http\Controllers\Admin\MouvementController::class, 'print_list'])->name('admin-mouvement-single-print-list');
    Route::get('/manager/mouvement/single/mouvement_print', [App\Http\Controllers\Admin\MouvementController::class, 'mouvement_print'])->name('admin-mouvement-single-mouvement-print');
    Route::post('/manager/mouvement/single/mouvement_print', [App\Http\Controllers\Admin\MouvementController::class, 'mouvement_print'])->name('admin-mouvement-single-mouvement-print');
    Route::post('/manager/mouvement/period_toggle', [App\Http\Controllers\Admin\MouvementController::class, 'togglePeriod'])
        ->name('admin-mouvement-period-toggle');
    Route::get('/manager/mouvement/employees-list/release', [App\Http\Controllers\Admin\MouvementController::class, 'emoloyees_list_release'])->name('admin-mouvement-employees-list-release');
    Route::post('/manager/mouvement/employees-list/release', [App\Http\Controllers\Admin\MouvementController::class, 'emoloyees_list_release'])->name('admin-mouvement-employees-list-release');


    /**
     *
     * absence
     *
     */

    Route::match(['get', 'post'], '/admin/absence', [App\Http\Controllers\Admin\AbsenceController::class, 'single_index'])
        ->name('admin-absence-single-employees');
    Route::get('/admin/absence/{MATRI}/print', [App\Http\Controllers\Admin\AbsenceController::class, 'absence_single_print'])->name('admin-absence-single-print');



    /**
     * settings
     */


    /**
     * notes
     */

    Route::get('/manager/settings/notes', [App\Http\Controllers\Admin\settings\NoteController::class, 'index'])->name('admin-settings-notes');
    Route::get('/manager/settings/note/create', [App\Http\Controllers\Admin\settings\NoteController::class, 'create'])->name('admin-settings-note-create');
    Route::post('/manager/settings/note/store', [App\Http\Controllers\Admin\settings\NoteController::class, 'store'])->name('admin-settings-note-store');
    Route::post('/manager/settings/note/delete', [App\Http\Controllers\Admin\settings\NoteController::class, 'destroy'])->name('admin-settings-note-delete');



    /**
     * employee
     */

    Route::get('/manager/settings/employee/list', [App\Http\Controllers\Admin\settings\EmployeeController::class, 'list'])->name('admin-settings-employee-list');
    Route::post('/manager/settings/employee/list', [App\Http\Controllers\Admin\settings\EmployeeController::class, 'list'])->name('admin-settings-employee-list');
    Route::get('/manager/settings/employee/{MATRI}/edit', [App\Http\Controllers\Admin\settings\EmployeeController::class, 'show'])->name('admin-settings-employee-edit');
    Route::post('/manager/settings/employee/store', [App\Http\Controllers\Admin\settings\EmployeeController::class, 'store'])->name('admin-settings-employee-store');

    /**
     * tresor
     */

    Route::match(['get', 'post'], '/manager/tresor/list', [TresorController::class, 'list'])
        ->name('admin-tresor-list');
    Route::get('/manager/tresor/{MATRI}/edit', [TresorController::class, 'show'])->name('admin-tresor-edit');
    Route::post('/manager/tresor/store', [TresorController::class, 'store'])->name('admin-tresor-store');
    Route::get('/manager/tresor/{MATRI}/delete', [TresorController::class, 'delete'])->name('admin-tresor-delete');
    Route::get('/manager/tresor/print', [TresorController::class, 'print'])->name('admin-tresor-print');

    Route::get('/manager/tresor/stat', [TresorController::class, 'stat'])->name('admin-tresor-stat');
    Route::get('/manager/tresor/establishment/{affect}/list', [TresorController::class, 'showByEstablishment'])
        ->name('admin-tresor-establishment-list');
    Route::get('/manager/tresor/sql', [TresorController::class, 'exportTresorToSQL'])->name('admin-tresor-sql');
    Route::get('/manager/tresor/excel', [TresorController::class, 'exportTresorToExcel'])->name('admin-tresor-excel');

    /**
     * fonction
     */
    // Index (عرض القائمة)
    Route::get('manager/settings/fonctions', [FonctionController::class, 'index'])
        ->name('admin-settings-fonctions-index');

    // Create (عرض الفورم)
    Route::get('manager/settings/fonctions/create', [FonctionController::class, 'create'])
        ->name('admin-settings-fonctions-create');

    // Store (إضافة جديد)
    Route::post('manager/settings/fonctions', [FonctionController::class, 'store'])
        ->name('admin-settings-fonctions-store');

    // Edit (عرض فورم التعديل)
    // عرض الفورم
    Route::get('manager/settings/fonctions/{CODEFONC}/edit', [FonctionController::class, 'edit'])
        ->name('admin-settings-fonctions-edit');

    // تنفيذ التعديل
    Route::post('manager/settings/fonctions/{CODEFONC}/update', [FonctionController::class, 'update'])
        ->name('admin-settings-fonctions-update');


    // Delete (حذف → POST بدل DELETE)
    Route::post('manager/settings/fonctions/{CODEFONC}/delete', [FonctionController::class, 'destroy'])
        ->name('admin-settings-fonctions-destroy');




    Route::get('manager', function () {
        return view('layouts.admin');
    })->name("admin-home");
});


//* without midleware (the login ) *//

//this route to show login form
Route::get('manager/login', function () {
    return view('admin/login');
})->name("admin-login");
//this for pass the login
Route::post('manager/login', [App\Http\Controllers\Admin\AdminLoginController::class, 'login'])->name("admin-login");
//this for logout
Route::post('manager/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('manager/login');
})->name('admin-logout');
