<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\Auth\AuthAdminController;
use App\Http\Controllers\Api\admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\admin\MovieController;
use App\Http\Controllers\Api\admin\DashboardController;
use App\Http\Controllers\Api\admin\CinemaController;
use App\Http\Controllers\Api\admin\AccountController;
use App\Http\Controllers\Api\admin\CountryController;
use App\Http\Controllers\Api\admin\GenreController;
use App\Http\Controllers\Api\admin\RatedController;


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
        Route::get('country', [CountryController::class,'countryIndex'])->name('country.index');
        Route::get('country/create', [CountryController::class,'countryCreate'])->name('country.create');
        Route::post('country/store', [CountryController::class,'countryStore'])->name('country.store');
        Route::get('country/edit/{id}', [CountryController::class,'countryEdit'])->name('country.edit');
        Route::put('country/update/{id}', [CountryController::class,'countryUpdate'])->name('country.update');
        Route::delete('country/delete/{id}', [CountryController::class,'countryDestroy'])->name('country.destroy');
        //genre
        Route::get('genre', [GenreController::class,'genreIndex'])->name('genre.index');
        Route::get('genre/create', [GenreController::class,'genreCreate'])->name('genre.create');
        Route::post('genre/store', [GenreController::class,'genreStore'])->name('genre.store');
        Route::get('genre/edit/{id}', [GenreController::class,'genreEdit'])->name('genre.edit');
        Route::put('genre/update/{id}', [GenreController::class,'genreUpdate'])->name('genre.update');
        Route::delete('genre/delete/{id}', [GenreController::class,'genreDestroy'])->name('genre.destroy');
        //rated
        Route::get('rated', [RatedController::class,'ratedIndex'])->name('rated.index');
        Route::get('rated/create', [RatedController::class,'ratedCreate'])->name('rated.create');
        Route::post('rated/store', [RatedController::class,'ratedStore'])->name('rated.store');
        Route::get('rated/edit/{id}', [RatedController::class,'ratedEdit'])->name('rated.edit');
        Route::put('rated/update/{id}', [RatedController::class,'ratedUpdate'])->name('rated.update');
        Route::delete('rated/delete/{id}', [RatedController::class,'ratedDestroy'])->name('rated.destroy');
        //movie
        Route::get('movie', [MovieController::class,'Index'])->name('movie.index');
    });
    Route::get('/logout', [AuthAdminController::class, 'logout'])-> name('auth.logout');


 
    
});





