<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
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

    public function store(Request $request)
    {
        SensorData::create($request->all());

        return response()->json(['message' => 'Data berhasil disimpan',], 201);
    }
}
