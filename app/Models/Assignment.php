<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_profile_id',
        'assigned_vehicle',
        'route_details',
        'incident_reports',
    ];

    public function driverProfile()
    {
        return $this->belongsTo(DriverProfile::class);
    }
}
