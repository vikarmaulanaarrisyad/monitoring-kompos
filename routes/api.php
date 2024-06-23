<?php

use App\Http\Controllers\ApiSensorDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ROUTE KIRIM DATA SENSOR
Route::apiResource('/sensordata', ApiSensorDataController::class);
