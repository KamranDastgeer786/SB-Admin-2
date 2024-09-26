<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PerformanceRecord;
use App\Models\DriverProfile;

class PerformanceRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all driver profiles to use for performance records
        $driverProfiles = DriverProfile::all();

        // Create dummy performance record data
        $performanceRecords = [
            [
                'driver_profile_id' => $driverProfiles->random()->id,
                'on_time_delivery_rate' => 95.5,
                'incident_involvements' => 1,
                'maintenance_compliance' => 'High',
            ],
            [
                'driver_profile_id' => $driverProfiles->random()->id,
                'on_time_delivery_rate' => 88.7,
                'incident_involvements' => 2,
                'maintenance_compliance' => 'Medium',
            ],
            [
                'driver_profile_id' => $driverProfiles->random()->id,
                'on_time_delivery_rate' => 92.3,
                'incident_involvements' => 0,
                'maintenance_compliance' => 'High',
            ],
        ];

        // Insert each performance record into the database
        foreach ($performanceRecords as $record) {
            PerformanceRecord::create($record);
        }
    }
}
