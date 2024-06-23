<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SensorDataController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ROUTE ALAT
    Route::get('/devices/data', [DeviceController::class, 'data'])->name('devices.data');
    Route::resource('/devices', DeviceController::class);

    // ROUTE HISTORY ALAT
    Route::get('/sensordata/data', [SensorDataController::class, 'data'])->name('sensordata.data');
    Route::resource('/sensordata', SensorDataController::class);
    Route::delete('/sensordata/delete_all', [SensorDataController::class, 'destroy'])->name('sensordata.delete_all');

    // ROUTE SETTING
    Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/setting/{setting}', [SettingController::class, 'update'])
        ->name('setting.update');
});
