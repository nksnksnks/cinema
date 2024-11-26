
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\SpecialDayController;

// auth app

    Route::apiResource('specialday', SpecialDayController::class)->withoutMiddleware(['role:admin', 'auth:sanctum']);;
