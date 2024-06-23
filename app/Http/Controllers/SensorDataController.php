<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use Illuminate\Http\Request;

class SensorDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('historyalat.index');
    }

    public function data()
    {
        $query = SensorData::orderBy('id', 'DESC');
        return datatables($query)
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SensorData $sensorData)
    {
        $sensorData->truncate();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function getLatestData()
    {
        // Fetch the latest sensor data
        $latestData = SensorData::latest()->first();

        // Check if data is available
        if ($latestData) {
            return response()->json([
                'success' => true,
                'data' => $latestData,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No data available.',
            ]);
        }
    }

    public function getAll()
    {
        // Fetch the latest sensor data
        $sensorData = SensorData::where('humidity', '>', 30)->orwhere('temperature', '>', 30)->limit(10)->orderBy('id', 'DESC')->get();

        // Check if data is available
        if ($sensorData) {
            return response()->json([
                'success' => true,
                'data' => $sensorData,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No data available.',
            ]);
        }
    }
}
