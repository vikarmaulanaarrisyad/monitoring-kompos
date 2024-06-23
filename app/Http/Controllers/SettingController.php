<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::first();
        return view('setting.index', compact('setting'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $rules = [
            'nama_aplikasi' => 'required',
            'singkatan_aplikasi' => 'required',
            'deskripsi_aplikasi' => 'nullable',
            'owner1' => 'required',
            'owner2' => 'required',
        ];

        if ($request->has('pills') && $request->pills == 'logo') {
            $rules = [
                'logo' => 'nullable|mimes:png,jpg,jpeg|max:2048',
                'favicon' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            ];
        }

        $request->validate($rules);
        $data = $request->except('logo', 'favicon');

        if ($request->hasFile('logo')) {
            if (Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }

            $data['logo'] = upload('setting', $request->file('logo'), 'setting');
        }

        if ($request->hasFile('favicon')) {
            if (Storage::disk('public')->exists($setting->favicon)) {
                Storage::disk('public')->delete($setting->favicon);
            }

            $data['favicon'] = upload('setting', $request->file('favicon'), 'setting');
        }

        $setting->update($data);

        return back()->with([
            'message' => 'Pengaturan berhasil diperbarui',
            'success' => true
        ]);
    }
}
