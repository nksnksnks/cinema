
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\MovieController;

// auth app

Route::apiResource('movies', MovieController::class)->withoutMiddleware(['role:admin', 'auth:sanctum']);;
Route::get('moviesby/{id}', [MovieController::class, 'show'])->withoutMiddleware(['role:admin', 'auth:sanctum']);;