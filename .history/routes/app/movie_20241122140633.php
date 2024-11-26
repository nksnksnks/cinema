
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\MovieController;

// auth app


<?php

use App\Http\Controllers\Api\app\CinemaController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/cinema'], function () {
    Route::get('/get-list', [CinemaController::class, 'getListCinema'])->withoutMiddleware(['role:user', 'auth:sanctum']);
});
