
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\app\TicketController;

Route::group(['prefix' => '/ticket'], function () {
    Route::post('/reservation', [TicketController::class, 'createReservation']);
    Route::post('/momo-payment', [TicketController::class, 'momoPayment']);
    Route::group(['middleware' => 'authenticate'], function(){
        Route::group(['middleware' => ['checkrole:4']], function () {
    Route::post('/cash-payment', [TicketController::class, 'cashPayment']);
        });});
    Route::get('/handle-momo-payment', [TicketController::class, 'handleMomoPayment'])->withoutMiddleware(['role:user', 'auth:sanctum']);
    Route::get('/get/{type}', [TicketController::class, 'getTicket']);
    Route::get('/detail/{id}', [TicketController::class, 'detailTicket'])->withoutMiddleware(['role:user', 'auth:sanctum']);;
    Route::get('/get-info-payment', [TicketController::class, 'getInfoPayment']);
    Route::get('/delete-reservation', [TicketController::class, 'deleteReservation']);
});

Route::middleware('auth:sanctum')->get('/get-ticket', [TicketController::class, 'getBillDetail']);
Route::middleware('auth:sanctum')->post('/check-bill', [TicketController::class, 'checkBill']);
