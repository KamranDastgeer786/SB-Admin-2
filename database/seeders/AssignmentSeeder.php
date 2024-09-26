<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Assignment;
use App\Models\DriverProfile;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all driver profiles to use for assignment
        $driverProfiles = DriverProfile::all();

        // Create dummy assignment records
        $assignments = [
            [
                'driver_profile_id' => $driverProfiles->random()->id,
                'assigned_vehicle' => 'Ford Transit',
                'route_details' => 'Route A',
                'incident_reports' => 'No incidents reported.',
            ],
            [
                'driver_profile_id' => $driverProfiles->random()->id,
                'assigned_vehicle' => 'Chevrolet Express',
                'route_details' => 'Route B',
                'incident_reports' => 'Minor incident reported.',
            ],
            [
                'driver_profile_id' => $driverProfiles->random()->id,
                'assigned_vehicle' => 'Mercedes Sprinter',
                'route_details' => 'Route C',
                'incident_reports' => 'No incidents reported.',
            ],
        ];

        // Insert each assignment into the database
        foreach ($assignments as $assignment) {
            Assignment::create($assignment);
        }
    }
}
