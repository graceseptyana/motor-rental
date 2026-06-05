<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\CalculationController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes([
    'register' => false,
    'reset'    => false,
    'verify'   => false
]);

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Upload
    |--------------------------------------------------------------------------
    */
    Route::prefix('upload')->name('upload.')->group(function () {

        Route::get('/', [UploadController::class, 'index'])
            ->name('index');

        Route::get('/reupload', [UploadController::class, 'reupload'])
            ->name('reupload');

        Route::post('/', [UploadController::class, 'store'])
            ->name('store');

        // 🔥 Hapus semua (WAJIB di atas parameter)
        Route::delete('/destroy-all', [UploadController::class, 'destroyAll'])
            ->name('destroyAll');

        // Hapus per motor type
        Route::delete('/{motorTypeId}', [UploadController::class, 'destroy'])
            ->whereNumber('motorTypeId')
            ->name('destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | Calculation
    |--------------------------------------------------------------------------
    */
    Route::prefix('calculation')->name('calculation.')->group(function () {

        Route::get('/', [CalculationController::class, 'index'])
            ->name('index');

        Route::post('/', [CalculationController::class, 'calculate'])
            ->name('calculate');
    });


    /*
    |--------------------------------------------------------------------------
    | Result
    |--------------------------------------------------------------------------
    */
    Route::prefix('result')->name('result.')->group(function () {

        Route::get('/{id}', [ResultController::class, 'show'])
            ->whereNumber('id')
            ->name('show');

        Route::get('/{id}/pdf', [ResultController::class, 'exportPdf'])
            ->whereNumber('id')
            ->name('pdf');
    });


    /*
    |--------------------------------------------------------------------------
    | History
    |--------------------------------------------------------------------------
    */
    Route::prefix('history')->name('history.')->group(function () {

        Route::get('/', [HistoryController::class, 'index'])
            ->name('index');

        // 🔥 Hapus semua (WAJIB di atas parameter)
        Route::delete('/destroy-all', [HistoryController::class, 'destroyAll'])
            ->name('destroyAll');

        Route::delete('/{id}', [HistoryController::class, 'destroy'])
            ->whereNumber('id')
            ->name('destroy');
    });

});