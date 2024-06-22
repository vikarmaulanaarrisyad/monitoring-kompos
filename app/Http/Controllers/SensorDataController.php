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
}
