
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\app\AuthController;
use App\Http\Controllers\Api\app\ChangePasswordController;

// auth app
Route::group(['prefix' => '/auth'], function () {
    Route::post('/register', [AuthController::class, 'register'])->withoutMiddleware(['role:user', 'auth:sanctum']);
    Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware(['role:user', 'auth:sanctum']);
});

Route::post('/change-password', [ChangePasswordController::class,'changePassword'])->middleware('auth:sanctum');