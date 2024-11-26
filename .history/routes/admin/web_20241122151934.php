<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndexController;

//admin controller
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\MovieAPIController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Auth\ChangepasswordController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\FacebookController;





Route::group(['middleware' => ['checklogin','checkcookie']], function () {  
    Route::get('/login', [LoginController::class, 'viewlogin'])->name('auth.login');
    Route::get('/register', [RegisterController::class, 'viewregister'])->name('auth.register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});



Route::group(['middleware' => 'authenticate'], function(){
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        Route::resource('category', CategoryController::class);
        Route::resource('genre', GenreController::class);
        Route::resource('country', CountryController::class);
        Route::resource('movie', MovieController::class);
        Route::delete('/movies/destroyMany', [MovieController::class, 'destroyMany'])->name('movies.destroyMany');
        Route::delete('/movies/destroy-all', [MovieController::class, 'destroyAll'])->name('movies.destroyAll');
 
    });
    Route::get('/logout', [LoginController::class, 'logout'])-> name('auth.logout');


 
    
});





