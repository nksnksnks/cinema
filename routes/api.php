<?php

use App\Http\Controllers\Api\APP\AuthController;
use Illuminate\Support\Facades\Route;

// API APP
Route::group(['prefix' => 'app', 'middleware' => ['role:user', 'auth:sanctum']], function () {

    \App\Helpers\RouteHelper::includeRouteFiles(__DIR__ . '/app');
});

// API ADMIN
Route::group(['prefix' => 'admin', 'middleware' => ['role:admin', 'auth:sanctum']], function () {

    \App\Helpers\RouteHelper::includeRouteFiles(__DIR__ . '/admin');
});

