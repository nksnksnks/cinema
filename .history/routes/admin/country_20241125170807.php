
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\CountryController;

// auth app



Route::prefix('countries')->group(function () {
    Route::get('/', [CountryController::class, 'index'])->name('countries.index');
    Route::post('/', [CountryController::class, 'store'])->name('admin.countries.store');
    Route::get('/{id}', [CountryController::class, 'show'])->name('admin.countries.show');
    Route::put('/{id}', [CountryController::class, 'update'])->name('admin.countries.update');
    Route::delete('/{id}', [CountryController::class, 'destroy'])->name('admin.countries.destroy');
});
