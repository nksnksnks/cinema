
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\app\TicketController;

Route::group(['prefix' => '/ticket'], function () {
    Route::post('/reservation', [TicketController::class, 'createReservation']);
    Route::post('/momo-payment', [TicketController::class, 'momoPayment']);
    Route::get('/handle-momo-payment', [TicketController::class, 'handleMomoPayment']);
    Route::get('/get/{type}', [TicketController::class, 'getTicket']);
    Route::get('/get-detail/{id}', [TicketController::class, 'detailTicket']);
});

