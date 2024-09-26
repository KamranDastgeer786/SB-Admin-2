<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_profile_id',
        'on_time_delivery_rate',
        'incident_involvements',
        'maintenance_compliance',
    ];

    public function driverProfile()
    {
        return $this->belongsTo(DriverProfile::class);
    }
}
