<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('devices.index');
    }

    public function data()
    {
        $query = Device::orderBy('id', 'DESC');

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('action', function ($q) {
                return '
                  <button onclick="editForm(`' . route('devices.show', $q->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></button>
                  <button onclick="deleteData(`' . route('devices.destroy', $q->id) . '`, `' . $q->name . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                  ';
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'device_name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Please check your input'], 422);
        }

        Device::create($request->all());

        return response()->json(['message' => 'Data berhasil disimpan.'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {
        return response()->json(['data' => $device]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Device $device)
    {
        $rules = [
            'device_name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Periksa kembali inputan anda'], 422);
        }
        $device->update($request->all());

        return response()->json(['message' => 'Data berhasil disimpan.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        $device->delete();
        return response()->json(['message' => 'Data berhasil dihapus.'], 200);
    }
}
