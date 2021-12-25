<?php

use App\Http\Controllers\Api\OpenWeatherMapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => '\App\Http\Controllers\Api'], function() {
    Route::prefix('weather')->group(function () {
        Route::post('/search',[OpenWeatherMapController::class,'search']);
    });
});

