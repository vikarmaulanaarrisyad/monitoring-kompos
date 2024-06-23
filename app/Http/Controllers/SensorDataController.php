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
            ->editColumn('device_id', function ($q) {
                return  $q->device->device_name;
            })
            ->editColumn('waktu', function ($q) {
                return tanggal_indonesia($q->created_at, false, true);
            })
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
        $sensorData = SensorData::where('humidity', '>', 30)
            ->orWhere('temperature', '>', 30)
            ->limit(10)
            ->orderBy('created_at', 'DESC')
            ->get();

        // Check if data is available
        if ($sensorData->isNotEmpty()) {
            // Format created_at to Y-m-d H:i:s with Asia/Jakarta timezone
            $formattedSensorData = $sensorData->map(function ($data) {
                $formattedDate = $data->created_at->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s');
                return [
                    'id' => $data->id,
                    'humidity' => $data->humidity,
                    'temperature' => $data->temperature,
                    'created_at' => $formattedDate,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $formattedSensorData,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No data available.',
            ]);
        }
    }
}
