
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\TimeController;

// auth app

    Route::apiResource('countries', CountryController::class)->withoutMiddleware(['role:admin', 'auth:sanctum']);;
