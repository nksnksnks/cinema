
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\CountryController;

// auth app

    // Route::apiResource('countries', CountryController::class)->withoutMiddleware(['role:admin', 'auth:sanctum']);
    Route::group(['prefix' => '/countries'], function () {
        Route::post('/index', [CountryController::class, 'index'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
        Route::post('/', [CountryController::class, 'updateCinema'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
        Route::get('/get-list', [CountryController::class, 'getListCinema'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
        Route::get('/get/{id}', [CountryController::class, 'getCinema'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
    });
    Route::prefix('countries')->group(function () {
        Route::get('/', [CountryController::class, 'index'])->name('admin.countries.index');
        Route::post('countries', [CountryController::class, 'store'])->name('admin.countries.store');
        Route::get('countries/{id}', [CountryController::class, 'show'])->name('admin.countries.show');
        Route::put('countries/{id}', [CountryController::class, 'update'])->name('admin.countries.update');
        Route::delete('countries/{id}', [CountryController::class, 'destroy'])->name('admin.countries.destroy');
    });