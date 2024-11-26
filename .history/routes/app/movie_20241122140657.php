
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\MovieController;

// auth app

Route::get('movieBygenre/{genre_id}', [MovieController::class, 'getMovieByGenre'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
Route::get('movieBycountry/{country_id}', [MovieController::class, 'getMovieByCountry'])->withoutMiddleware(['role:admin', 'auth:sanctum']);