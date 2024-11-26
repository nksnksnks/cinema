
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\WeeklyTicketPriceController;

// auth app

    Route::apiResource('w', WeeklyTicketPriceController::class)->withoutMiddleware(['role:admin', 'auth:sanctum']);;
