<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SensorData extends Model
{
    use HasFactory;

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
