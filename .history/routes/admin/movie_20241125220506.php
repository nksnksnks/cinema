
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\MovieController;

// auth app

Route::apiResource('movies', MovieController::class)->withoutMiddleware(['role:admin', 'auth:sanctum']);
Route::prefix('genres')->group(function () {
    Route::get('/', [GenreController::class, 'index'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
    Route::post('/', [GenreController::class, 'store'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
    Route::get('/{id}', [GenreController::class, 'show'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
    Route::put('/{id}', [GenreController::class, 'update'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
    Route::delete('/{id}', [GenreController::class, 'destroy'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
});