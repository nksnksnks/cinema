
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\CountryController;

// auth app



Route::prefix('/countries')->group(function () {
    Route::get('/index', [CountryController::class, 'index']);
    Route::post('/', [CountryController::class, 'store'])->name('countries.store');
    Route::get('/{id}', [CountryController::class, 'show'])->name('countries.show');
    Route::put('/{id}', [CountryController::class, 'update'])->name('countries.update');
    Route::delete('/{id}', [CountryController::class, 'destroy'])->name('countries.destroy');
});
