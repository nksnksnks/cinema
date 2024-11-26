
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\WeeklyTicketPriceController;

// auth app

    Route::apiResource('wee', WeeklyTicketPriceController::class)->withoutMiddleware(['role:admin', 'auth:sanctum']);;
