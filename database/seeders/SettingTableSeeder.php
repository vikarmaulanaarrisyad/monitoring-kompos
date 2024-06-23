<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = new Setting();
        $setting->nama_aplikasi = 'Monitoring Kompos';
        $setting->singkatan_aplikasi = 'MK';
        $setting->deskripsi_aplikasi = 'Monitoring Kompos';
        $setting->owner1 = 'Owner 1';
        $setting->owner2 = 'Owner 2';
        $setting->save();
    }
}
