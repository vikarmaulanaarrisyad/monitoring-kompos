<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SensorDataController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/devices/data', [DeviceController::class, 'data'])->name('devices.data');
    Route::resource('devices', DeviceController::class);
    Route::resource('sensordata', SensorDataController::class);
});
