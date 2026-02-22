
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Absence\SecurityPinController;
use App\Http\Controllers\Absence\AbsenceLoginController;

Route::get('absence/login', function () {
    return view('absence/login');
})->name("absence-login");

Route::post('absence/login', [AbsenceLoginController::class, 'login'])->name("post-absence-login");

Route::match(['get', 'post'], 'absence/logout', function () {
    Auth::logout();
    session()->forget('pin_verified');
    session()->invalidate();
    session()->regenerateToken();

    return redirect()->route('absence-login');
})->name('absence-logout');

Route::middleware(['auth'])->group(function () {
    Route::get('absence/pin/create', [SecurityPinController::class, 'createPin'])->name('pin.create');
    Route::post('absence/pin/create', [SecurityPinController::class, 'store'])->name('pin.create.store');

    Route::get('absence/pin/verify', [SecurityPinController::class, 'showVerifyForm'])->name('pin.verify');
    Route::post('absence/pin/verify', [SecurityPinController::class, 'check'])->name('pin.check');
});

Route::group([
    'prefix' => '',
    'middleware' => array_merge(
        env("APP_ENV", "local") == "local" ? ['auth'] : ['auth', 'role:abs-admin'],
        ['absence.pin']
    ),
], function () {
    Route::get('/absence/reservation', [App\Http\Controllers\Absence\AbsenceReservationController::class, 'index'])->name('absence-reservation');
    Route::get('/absence/reservation/{absence_reservation_id}/employees/list', [App\Http\Controllers\Absence\AbsenceReservationController::class, 'reservationList'])->name("absence-reservation-employees-list");
    Route::post('/absence/reservation/{absence_reservation_id}/employees/list', [App\Http\Controllers\Absence\AbsenceReservationController::class, 'reservationList'])->name("absence-reservation-employees-list");
    Route::get('/absence/reservation/{absence_reservation_id}/print', [App\Http\Controllers\Absence\AbsenceReservationController::class, 'absence_reservation_print'])->name('absence-reservation-print');
    Route::get('/absence/reservation/{id}/cancel', [App\Http\Controllers\Absence\AbsenceReservationController::class, 'destroy'])->name('absence-reservation-cancel');
    Route::get('/absence/reservation/get-employee/{MATRI}', [App\Http\Controllers\Absence\AbsenceReservationController::class, 'getEmployee'])->name('get-employee');
    Route::post('/absence/reservation/insert-absence', [App\Http\Controllers\Absence\AbsenceReservationController::class, 'insertAbsence'])->name('insert-absence');

    Route::match(['get', 'post'], '/absence/single', [App\Http\Controllers\Absence\AbsenceReservationController::class, 'single_index'])
        ->name('absence-single-employees');
    Route::get('/absence/single/{MATRI}/print', [App\Http\Controllers\Absence\AbsenceReservationController::class, 'absence_single_print'])->name('absence-single-print');

    Route::get('/absence/validation', [App\Http\Controllers\Absence\AbsenceValidationController::class, 'index'])->name('absence-validation');
    Route::post('/absence/validation', [App\Http\Controllers\Absence\AbsenceValidationController::class, 'validation'])->name('post-absence-validation');

    Route::get('absence', function () {
        return view('layouts.absence');
    })->name("absence-home");
});
