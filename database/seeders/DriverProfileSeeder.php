<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DriverProfile;

class DriverProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create dummy driver profile records
        $driverProfiles = [
            [
                'full_name' => 'John Doe',
                'license_number' => 'D1234567',
                'vehicle_information' => 'Toyota Camry',
                'contact_details' => '1234567890',
            ],
            [
                'full_name' => 'Alice Smith',
                'license_number' => 'D9876543',
                'vehicle_information' => 'Honda Accord',
                'contact_details' => '2345678901',
            ],
            [
                'full_name' => 'Michael Johnson',
                'license_number' => 'D6543210',
                'vehicle_information' => 'Ford F-150',
                'contact_details' => '3456789012',
            ],
        ];

        // Insert each driver profile into the database
        foreach ($driverProfiles as $driverProfile) {
            DriverProfile::create($driverProfile);
        }
    }
}
