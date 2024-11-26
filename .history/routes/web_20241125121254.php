<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\Auth\AuthAdminController;
use App\Http\Controllers\Api\admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\admin\MovieController;
use App\Http\Controllers\Api\admin\DashboardController;
use App\Http\Controllers\Api\admin\CinemaController;


Route::get('/', [DashboardController::class, 'homepage']);
Route::get('/homepage', [DashboardController::class, 'home'])->name('homepage');


Route::group(['middleware' => ['checklogin']], function () {  
    Route::get('/login', [AuthAdminController::class, 'viewlogin'])->name('auth.login');
    Route::get('/register', [AuthAdminController::class, 'viewregister'])->name('auth.register');
    Route::post('/register', [AuthAdminController::class, 'register'])->name('register');
    Route::post('/login', [AuthAdminController::class, 'login'])->name('login');
});
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'checkForgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password/{token}', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');


Route::group(['middleware' => 'authenticate'], function(){
    Route::group(['middleware' => ['checkrole:1']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        Route::get('cinema/store', [CinemaController::class,'create'])->name('cinema.store');
        Route::post('v1/admin/cinema/create', [CinemaController::class,'CinemaStore'])->name('cinema.create');
       
 
    });
    Route::get('/logout', [AuthAdminController::class, 'logout'])-> name('auth.logout');


 
    
});





