
<?php

use App\Http\Controllers\Admin\EmployeeControlle;

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => '', 'middleware' => env("APP_ENV", "local") == "local" ? [] : [ 'role:manager']], function () {



    /**
     * employee
     */


    Route::get('/root/user/list', [App\Http\Controllers\Root\UserController::class, 'list'])->name('root-user-list');
    Route::post('/root/user/list', [App\Http\Controllers\Root\UserController::class, 'list'])->name('root-user-list');
    Route::get('/root/user/{id}/edit', [App\Http\Controllers\Root\UserController::class, 'show'])->name('root-user-edit');
    Route::post('/root/user/store', [App\Http\Controllers\Root\UserController::class, 'store'])->name('root-user-store');
    Route::post('/root/user/{id}/activities', [App\Http\Controllers\Root\UserController::class, 'activities'])->name('root-user-activities');
    Route::get('/root/user/{id}/activities', [App\Http\Controllers\Root\UserController::class, 'activities'])->name('root-user-activities');



});

