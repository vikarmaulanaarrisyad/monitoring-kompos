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
        $user = User::where('id', '1')->first(); // Sebaiknya ID ini diubah menjadi dinamis atau diambil dari konteks lain

        // Ambil data dari request
        $temperature = $request->input('temperature');
        $humidity = $request->input('humidity');
        $kapasitas1 = $request->input('kapasitas1');
        $kapasitas2 = $request->input('kapasitas2');
        $status = $request->input('status');
        $status2 = $request->input('status2');

        // Simpan data sensor
        SensorData::create([
            'temperature' => $temperature,
            'humidity' => $humidity,
            'kapasitas1' => $kapasitas1,
            'kapasitas2' => $kapasitas2,
            'status' => $status,
            'status2' => $status2,
        ]);

        // Periksa kondisi suhu dan kelembapan untuk notifikasi
        if ($temperature > 30 || $humidity > 30) {
            $message = 'Suhu Terlalu Tinggi';
            $user->notify(new NewNotification($user, $message));
        }

        return response()->json(['message' => 'Data berhasil disimpan'], 201);
    }
}
