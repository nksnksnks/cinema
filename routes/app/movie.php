
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\MovieController;

// auth app


Route::get('movies', [MovieController::class, 'getMovies'])->withoutMiddleware(['role:user', 'auth:sanctum']);
