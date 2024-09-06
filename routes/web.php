<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SensorDataController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserProfileInformationController;
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
    Route::get('/sensordata/chart', [SensorDataController::class, 'getChartData'])->name('sensordata.chart');
    Route::get('/sensordata/data', [SensorDataController::class, 'data'])->name('sensordata.data');
    Route::get('/sensordata/get_latest_data', [SensorDataController::class, 'getLatestData'])->name('sensordata.get_latest_data');
    Route::get('/sensordata/getAll', [SensorDataController::class, 'getAll'])->name('sensordata.getAll');
    Route::resource('/sensordata', SensorDataController::class);
    Route::delete('/sensordata/delete_all', [SensorDataController::class, 'destroy'])->name('sensordata.delete_all');

    // ROUTE SETTING
    Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/setting/{setting}', [SettingController::class, 'update'])
        ->name('setting.update');

    // ROUTE USERPROFILE
    Route::get('/user/profile', [UserProfileInformationController::class, 'show'])
        ->name('profile.show');
    Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications.get');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::get('/notifications/count', [NotificationController::class, 'countUnread'])->name('notifications.count');
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    // Route di web.php
});
