
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\RatedController;

// auth app

    Route::apiResource('rateds', RatedController::class)->withoutMiddleware(['role:admin', 'auth:sanctum']);;
