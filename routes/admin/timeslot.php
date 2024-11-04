
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\TimeSlotController;

// auth app

    Route::apiResource('timeslots', TimeSlotController::class)->withoutMiddleware(['role:admin', 'auth:sanctum']);;
