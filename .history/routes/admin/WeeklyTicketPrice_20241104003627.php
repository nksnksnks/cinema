
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\WeeklyTicketPrice.php;

// auth app

    Route::apiResource('specialdays', SpecialDayController::class)->withoutMiddleware(['role:admin', 'auth:sanctum']);;
