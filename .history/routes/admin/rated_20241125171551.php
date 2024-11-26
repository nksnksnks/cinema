
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\RatedController;

// auth app

Route::prefix('rateds')->group(function () {
    Route::get('/', [CountryController::class, 'index'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
    Route::post('/', [CountryController::class, 'store'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
    Route::get('/{id}', [CountryController::class, 'show'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
    Route::put('/{id}', [CountryController::class, 'update'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
    Route::delete('/{id}', [CountryController::class, 'destroy'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
});