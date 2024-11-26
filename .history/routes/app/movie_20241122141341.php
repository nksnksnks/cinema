
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\MovieController;

// auth app

Route::get('movieBygenre/{genre_id}', [MovieController::class, 'getMovieByGenre'])->withoutMiddleware(['role:user', 'auth:sanctum']);
Route::get('movieBystatus', [MovieController::class, 'getMovieByStatus'])->withoutMiddleware(['role:admin', 'auth:sanctum']);