
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\CountryController;

// auth app



Route::prefix('countries')->group(function () {
    Route::get('/', [CountryController::class, 'index'])->name('admin.countries.index');
    Route::post('countries', [CountryController::class, 'store'])->name('admin.countries.store');
    Route::get('countries/{id}', [CountryController::class, 'show'])->name('admin.countries.show');
    Route::put('countries/{id}', [CountryController::class, 'update'])->name('admin.countries.update');
    Route::delete('countries/{id}', [CountryController::class, 'destroy'])->name('admin.countries.destroy');
});
