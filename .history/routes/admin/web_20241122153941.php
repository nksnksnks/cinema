<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\AuthAdminController;
use App\Http\Controllers\Api\admin\MovieController;




Route::group(['middleware' => ['checklogin','checkcookie']], function () {  
    Route::get('/login', [AuthAdminController::class, 'viewlogin'])->name('auth.login');
    Route::get('/register', [AuthAdminController::class, 'viewregister'])->name('auth.register');
    Route::post('/register', [AuthAdminController::class, 'register'])->name('register');
    Route::post('/login', [AuthAdminController::class, 'login'])->name('login');
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





