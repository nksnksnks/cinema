
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\admin\CategoryController;

// auth app
Route::group(['prefix' => '/category'], function () {
    Route::post('/create-category', [CategoryController::class, 'createCategory']);
    Route::post('/edit-category', [CategoryController::class, 'editCategory']);
    Route::get('/get-list-category', [CategoryController::class, 'getListCategory']);
    Route::delete('/delete-category', [CategoryController::class, 'deleteCategory']);
});

