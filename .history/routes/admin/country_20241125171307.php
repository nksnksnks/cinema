
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
        Route::get('/', [CountryController::class, 'index'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
        Route::post('/', [CountryController::class, 'store'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
        Route::get('/{id}', [CountryController::class, 'show'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
        Route::put('/{id}', [CountryController::class, 'update'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
        Route::delete('/{id}', [CountryController::class, 'destroy'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
    });