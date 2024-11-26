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



Route::get('/', [IndexController::class, 'index'])->name('homepage');

Route::group(['middleware' => ['checklogin','checkcookie']], function () {  
    Route::get('/login', [LoginController::class, 'viewlogin'])->name('auth.login');
    Route::get('/register', [RegisterController::class, 'viewregister'])->name('auth.register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'checkForgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password/{token}', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');



Route::group(['middleware' => 'authenticate'], function(){
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        Route::resource('category', CategoryController::class);
        Route::resource('genre', GenreController::class);
        Route::resource('country', CountryController::class);
        Route::resource('movie', MovieController::class);
        Route::delete('/movies/destroyMany', [MovieController::class, 'destroyMany'])->name('movies.destroyMany');
        Route::delete('/movies/destroy-all', [MovieController::class, 'destroyAll'])->name('movies.destroyAll');


        Route::get('/episode/index', [EpisodeController::class, 'index'])->name('episode.index');
        Route::get('/episode/{id}', [EpisodeController::class, 'create'])->name('episode.create');
        Route::post('/episode', [EpisodeController::class, 'store'])->name('episode.store');
        Route::get('/episode/edit/{id}', [EpisodeController::class, 'edit'])->name('episode.edit');
        Route::put('/episode/update/{id}', [EpisodeController::class, 'update'])->name('episode.update');
        Route::delete('/episode/delete/{id}', [EpisodeController::class, 'destroy'])->name('episode.destroy');
        
        Route::resource('year', YearController::class);

        // route dùng để đồng bộ tất cả các tập cho 1 phim từ API ophim
        Route::post('/episodes/{slug}', [EpisodeController::class, 'createEpisodeApi'])->name('episodes.createApi');
        // route dùng để đồng bộ tất cả các tập phim từ API ophim
        Route::get('episodes/all', [EpisodeController::class, 'syncAllEpisodes'])->name('episodes.createAll');
        // route dùng để đồng bộ tất cả các tập cho 1 phim từ API kkphim
        Route::post('/episodeskk/{slug}', [EpisodeController::class, 'createEpisodeApikk'])->name('episodes.createApikk');
        // route dùng để đồng bộ tất cả các tập phim từ API kkphim
        Route::get('episodeskk/all', [EpisodeController::class, 'syncAllEpisodeskk'])->name('episodes.createAllkk');
       
        // Route::put('/updateposter',[EpisodeController::class, 'test'])->name('update.poster');

        // route dùng để import phim từ API Ophim
        Route::get('movies/api-import', [MovieAPIController::class, 'index'])->name('movies.api_import.index');
        Route::post('movies/api-importop', [MovieAPIController::class, 'store'])->name('movies.api_import.store');
        // route dùng để import phim từ API KKphim
        Route::post('movies/api-importkk', [MovieAPIController::class, 'storekk'])->name('movies.api_import.storekk');

        //route dùng để import phim từ nhiều page API Ophim
        Route::get('movies/api-import1', [MovieAPIController::class, 'index1'])->name('movies.api_import.index1');
        Route::post('movies/api-importop1', [MovieAPIController::class, 'store1'])->name('movies.api_import.store1');
        // route dùng để import phim từ API KKphim
        Route::post('movies/api-importkk1', [MovieAPIController::class, 'storekk1'])->name('movies.api_import.storekk1');

        // route dùng để import 1 phim từ API ophim
        Route::get('movies/import', [MovieAPIController::class, 'show'])->name('movies.import.show');
        Route::post('movies/import', [MovieAPIController::class, 'storeSingleMovie'])->name('movies.import.store');

        // route dùng để import 1 phim từ API kkphim
        Route::post('movies/importkk', [MovieAPIController::class, 'storeSingleMoviekk'])->name('movies.import.storekk');

        //checklink kkphim
        Route::get('movies/showkk/{slug}', [MovieAPIController::class, 'showkk'])->name('movies.showkk');

        //update episode
        Route::get('getpage/apiophim', [EpisodeController::class, 'index1'])->name('getpage.apiophim');
        Route::post('updateapi/episode', [EpisodeController::class, 'updateEpisode'])->name('updateEpisode');
        Route::post('updateapi/episodekk', [EpisodeController::class, 'updateEpisodekk'])->name('updateEpisodekk');
        
    });
    Route::get('/logout', [LoginController::class, 'logout'])-> name('auth.logout');


 
    
});





