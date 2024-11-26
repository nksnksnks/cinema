<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\Auth\AuthAdminController;
use App\Http\Controllers\Api\admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\admin\MovieController;
use App\Http\Controllers\Api\admin\DashboardController;
use App\Http\Controllers\Api\admin\CinemaController;
use App\Http\Controllers\Api\admin\AccountController;
use App\Http\Controllers\Api\admin\CountryController;
use App\Http\Controllers\Api\admin\GenreController;
use App\Http\Controllers\Api\admin\RatedController;
use App\Http\Controllers\Api\admin\SpecialDayController;
use App\Http\Controllers\Api\admin\TimeSlotController;
use App\Http\Controllers\Api\admin\WeeklyTicketPriceController;
use App\Http\Controllers\Api\admin\RoomController;
use App\Http\Controllers\Api\admin\SeatTypeController;


Route::get('/', [DashboardController::class, 'homepage']);
Route::get('/homepage', [DashboardController::class, 'home'])->name('homepage');


Route::group(['middleware' => ['checklogin']], function () {  
    Route::get('/login', [AuthAdminController::class, 'viewlogin'])->name('auth.login');
    Route::post('/login', [AuthAdminController::class, 'login'])->name('login');
});
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'checkForgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password/{token}', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');


Route::group(['middleware' => 'authenticate'], function(){
    Route::group(['middleware' => ['checkrole:1']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        //cinema
        Route::get('cinema', [CinemaController::class,'index'])->name('cinema.index');
        Route::get('cinema/store', [CinemaController::class,'create'])->name('cinema.store');
        Route::post('v1/admin/cinema/create', [CinemaController::class,'CinemaStore'])->name('cinema.create');
        Route::get('cinema/edit/{id}', [CinemaController::class,'edit'])->name('cinema.edit');
        Route::put('v1/admin/cinema/update/{id}', [CinemaController::class,'CinemaUpdate'])->name('cinema.update');
        Route::delete('v1/admin/cinema/delete/{id}', [CinemaController::class,'destroy'])->name('cinema.delete');
        //account
        Route::get('account', [AccountController::class,'index'])->name('account.index');
        Route::get('/register', [AuthAdminController::class, 'viewregister'])->name('auth.register');
        Route::post('/register', [AuthAdminController::class, 'register'])->name('register');
        Route::get('account/edit/{id}', [AccountController::class,'edit'])->name('account.edit');
        Route::put('v1/admin/account/update/{id}', [AccountController::class,'update'])->name('account.update');
        Route::delete('account/delete/{id}', [AccountController::class,'destroy'])->name('account.destroy');
        //country
        Route::get('country', [CountryController::class,'countryIndex'])->name('country.index');
        Route::get('country/create', [CountryController::class,'countryCreate'])->name('country.create');
        Route::post('country/store', [CountryController::class,'countryStore'])->name('country.store');
        Route::get('country/edit/{id}', [CountryController::class,'countryEdit'])->name('country.edit');
        Route::put('country/update/{id}', [CountryController::class,'countryUpdate'])->name('country.update');
        Route::delete('country/delete/{id}', [CountryController::class,'countryDestroy'])->name('country.destroy');
        //genre
        Route::get('genre', [GenreController::class,'genreIndex'])->name('genre.index');
        Route::get('genre/create', [GenreController::class,'genreCreate'])->name('genre.create');
        Route::post('genre/store', [GenreController::class,'genreStore'])->name('genre.store');
        Route::get('genre/edit/{id}', [GenreController::class,'genreEdit'])->name('genre.edit');
        Route::put('genre/update/{id}', [GenreController::class,'genreUpdate'])->name('genre.update');
        Route::delete('genre/delete/{id}', [GenreController::class,'genreDestroy'])->name('genre.destroy');
        //rated
        Route::get('rated', [RatedController::class,'ratedIndex'])->name('rated.index');
        Route::get('rated/create', [RatedController::class,'ratedCreate'])->name('rated.create');
        Route::post('rated/store', [RatedController::class,'ratedStore'])->name('rated.store');
        Route::get('rated/edit/{id}', [RatedController::class,'ratedEdit'])->name('rated.edit');
        Route::put('rated/update/{id}', [RatedController::class,'ratedUpdate'])->name('rated.update');
        Route::delete('rated/delete/{id}', [RatedController::class,'ratedDestroy'])->name('rated.destroy');
        //movie
        Route::get('movie', [MovieController::class,'movieIndex'])->name('movie.index');
        Route::get('movie/create', [MovieController::class,'movieCreate'])->name('movie.create');
        Route::post('movie/store', [MovieController::class,'movieStore'])->name('movie.store');
        Route::get('movie/edit/{id}', [MovieController::class,'movieEdit'])->name('movie.edit');
        Route::put('movie/update/{id}', [MovieController::class,'movieUpdate'])->name('movie.update');
        Route::delete('movie/delete/{id}', [MovieController::class,'movieDestroy'])->name('movie.destroy');
        //specialday
        Route::get('specialday', [SpecialDayController::class,'specialdayIndex'])->name('specialday.index');
        Route::get('specialday/create', [SpecialDayController::class,'specialdayCreate'])->name('specialday.create');
        Route::post('specialday/store', [SpecialDayController::class,'specialdayStore'])->name('specialday.store');
        Route::get('specialday/edit/{id}', [SpecialDayController::class,'specialdayEdit'])->name('specialday.edit');
        Route::put('specialday/update/{id}', [SpecialDayController::class,'specialdayUpdate'])->name('specialday.update');
        Route::delete('specialday/delete/{id}', [SpecialDayController::class,'specialdayDestroy'])->name('specialday.destroy');
        //timeslot
        Route::get('timeslot', [TimeSlotController::class,'timeslotIndex'])->name('timeslot.index');
        Route::get('timeslot/create', [TimeSlotController::class,'timeslotCreate'])->name('timeslot.create');
        Route::post('timeslot/store', [TimeSlotController::class,'timeslotStore'])->name('timeslot.store');
        Route::get('timeslot/edit/{id}', [TimeSlotController::class,'timeslotEdit'])->name('timeslot.edit');
        Route::put('timeslot/update/{id}', [TimeSlotController::class,'timeslotUpdate'])->name('timeslot.update');
        Route::delete('timeslot/delete/{id}', [TimeSlotController::class,'timeslotDestroy'])->name('timeslot.destroy');
        //weeklyticketprice
        Route::get('weeklyticketprice', [WeeklyTicketPriceController::class,'weeklyticketpriceIndex'])->name('weeklyticketprice.index');
        Route::get('weeklyticketprice/create', [WeeklyTicketPriceController::class,'weeklyticketpriceCreate'])->name('weeklyticketprice.create');
        Route::post('weeklyticketprice/store', [WeeklyTicketPriceController::class,'weeklyticketpriceStore'])->name('weeklyticketprice.store');
        Route::get('weeklyticketprice/edit/{id}', [WeeklyTicketPriceController::class,'weeklyticketpriceEdit'])->name('weeklyticketprice.edit');
        Route::put('weeklyticketprice/update/{id}', [WeeklyTicketPriceController::class,'weeklyticketpriceUpdate'])->name('weeklyticketprice.update');
        Route::delete('weeklyticketprice/delete/{id}', [WeeklyTicketPriceController::class,'weeklyticketpriceDestroy'])->name('weeklyticketprice.destroy');
        //room
        Route::get('room', [RoomController::class,'roomIndex'])->name('room.index');
        Route::get('room/create', [RoomController::class,'roomCreate'])->name('room.create');
        Route::post('room/store', [RoomController::class,'roomStore'])->name('room.store');
        Route::get('room/edit/{id}', [RoomController::class,'roomEdit'])->name('room.edit');
        Route::put('room/update/{id}', [RoomController::class,'roomUpdate'])->name('room.update');
        Route::delete('room/delete/{id}', [RoomController::class,'roomDestroy'])->name('room.destroy');
        //seattype
        Route::get('seattype', [SeatTypeController::class,'seattypeIndex'])->name('seattype.index');
        Route::get('seattype/create', [SeatTypeController::class,'seattypeCreate'])->name('seattype.create');
        Route::post('seattype/store', [SeatTypeController::class,'seattypeStore'])->name('seattype.store');
        Route::get('seattype/edit/{id}', [SeatTypeController::class,'seattypeEdit'])->name('seattype.edit');
        Route::put('seattype/update/{id}', [SeatTypeController::class,'seattypeUpdate'])->name('seattype.update');
        Route::delete('seattype/delete/{id}', [SeatTypeController::class,'seattypeDestroy'])->name('seattype.destroy');
        //movieshowtime
        Route::get('movieshowtime', [MovieShowTimeController::class,'movieshowtimeIndex'])->name('movieshowtime.index');
        
    });
    Route::get('/logout', [AuthAdminController::class, 'logout'])-> name('auth.logout');


 
    
});





