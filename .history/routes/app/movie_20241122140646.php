
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\MovieController;

// auth app

Route::get('movieBygenre/{genre_id}', [MovieController::class, 'getMovieByGenre'])->withoutMiddleware(['role:admin', 'auth:sanctum']);
