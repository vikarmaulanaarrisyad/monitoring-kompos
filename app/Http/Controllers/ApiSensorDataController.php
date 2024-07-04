<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use App\Models\User;
use App\Notifications\NewNotification;
use Illuminate\Http\Request;

class ApiSensorDataController extends Controller
{
    public function index()
    {
        $result = SensorData::all();
        return response()->json([
            'data' => $result
        ]);
    }

    public function store1(Request $request)
    {
        $user = User::where('id', 1)->first();

        if ($request->temperature > 30 || $request->humidity > 30) {
            $message = 'Suhu Terlalu Tinggi';
            $user->notify(new NewNotification($user, $message));
        }

        SensorData::create($request->all());

        return response()->json(['message' => 'Data berhasil disimpan',], 201);
    }
    public function store(Request $request)
    {
        // Dapatkan user yang akan diberi notifikasi
        $user = User::find(1); // Sebaiknya ID ini diubah menjadi dinamis atau diambil dari konteks lain

        // Periksa kondisi suhu dan kelembapan
        if ($request->temperature > 30 || $request->humidity > 30) {
            $message = 'Suhu Terlalu Tinggi';
            $user->notify(new NewNotification($user, $message));
        }

        // Simpan data sensor
        SensorData::create($request->all());

        return response()->json(['message' => 'Data berhasil disimpan'], 201);
    }


}
