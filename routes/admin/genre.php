
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\GenreController;

// auth app
Route::group(['prefix' => '/genre'], function () {
    Route::apiResource('genres', GenreController::class)->withoutMiddleware(['role:admin', 'auth:sanctum']);;
});