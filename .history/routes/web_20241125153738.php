<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\Auth\AuthAdminController;
use App\Http\Controllers\Api\admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\admin\MovieController;
use App\Http\Controllers\Api\admin\DashboardController;
use App\Http\Controllers\Api\admin\CinemaController;
use App\Http\Controllers\Api\admin\AccountController;
use App\Http\Controllers\Api\admin\CountryController;


Route::get('/', [DashboardController::class, 'homepage']);
Route::get('/homepage', [DashboardController::class, 'home'])->name('homepage');


Route::group(['middleware' => ['checklogin']], function () {  
    Route::get('/login', [AuthAdminController::class, 'viewlogin'])->name('auth.login');
    Route::post('/login', [AuthAdminController::class, 'login'])->name('login');
});
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'checkForgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password/{token}', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');


Route::group(['middleware' => 'authenticate'], function(){
    Route::group(['middleware' => ['checkrole:1']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        //cinema
        Route::get('cinema', [CinemaController::class,'index'])->name('cinema.index');
        Route::get('cinema/store', [CinemaController::class,'create'])->name('cinema.store');
        Route::post('v1/admin/cinema/create', [CinemaController::class,'CinemaStore'])->name('cinema.create');
        Route::get('cinema/edit/{id}', [CinemaController::class,'edit'])->name('cinema.edit');
        Route::put('v1/admin/cinema/update/{id}', [CinemaController::class,'CinemaUpdate'])->name('cinema.update');
        Route::delete('v1/admin/cinema/delete/{id}', [CinemaController::class,'destroy'])->name('cinema.delete');
        //account
        Route::get('account', [AccountController::class,'index'])->name('account.index');
        Route::get('/register', [AuthAdminController::class, 'viewregister'])->name('auth.register');
        Route::post('/register', [AuthAdminController::class, 'register'])->name('register');
        Route::get('account/edit/{id}', [AccountController::class,'edit'])->name('account.edit');
        Route::put('v1/admin/account/update/{id}', [AccountController::class,'update'])->name('account.update');
        Route::delete('account/delete/{id}', [AccountController::class,'destroy'])->name('account.destroy');
        //country
        Route::get('country/create', [CountryController::class,'countryCreate'])->name('country.cre');
        Route::post('country/store', [CountryController::class,'countryStore'])->name('country.create');
    });
    Route::get('/logout', [AuthAdminController::class, 'logout'])-> name('auth.logout');


 
    
});





