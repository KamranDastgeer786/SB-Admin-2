<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'license_number',
        'vehicle_information',
        'contact_details',
    ];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function performanceRecords()
    {
        return $this->hasMany(PerformanceRecord::class);
    }
}
