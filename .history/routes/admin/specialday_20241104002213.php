
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\s;

// auth app

    Route::apiResource('timeslots', TimeSlotController::class)->withoutMiddleware(['role:admin', 'auth:sanctum']);;
