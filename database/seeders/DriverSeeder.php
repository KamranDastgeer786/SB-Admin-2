<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Driver;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create dummy driver records
        $drivers = [
            [
                'name' => 'John Doe',
                'date_of_birth' => '1985-04-23',
                'contact_number' => '1234567890',
                'email' => 'john@example.com',
                'license_number' => 'D1234567',
                'license_issuing_state' => 'CA',
                'license_expiry_date' => '2025-05-01',
                'vehicle_make_model' => 'Toyota Camry',
                'vehicle_registration_number' => 'XYZ123',
                'insurance_details' => 'Allstate Insurance, Policy #12345',
                'emergency_contact_name' => 'Jane Doe',
                'emergency_contact_number' => '0987654321',
                'emergency_contact_relationship' => 'Spouse',
            ],
            [
                'name' => 'Alice Smith',
                'date_of_birth' => '1990-07-12',
                'contact_number' => '2345678901',
                'email' => 'alice@example.com',
                'license_number' => 'D9876543',
                'license_issuing_state' => 'NY',
                'license_expiry_date' => '2026-10-10',
                'vehicle_make_model' => 'Honda Accord',
                'vehicle_registration_number' => 'ABC456',
                'insurance_details' => 'Geico Insurance, Policy #67890',
                'emergency_contact_name' => 'Bob Smith',
                'emergency_contact_number' => '0123456789',
                'emergency_contact_relationship' => 'Brother',
            ],
            [
                'name' => 'Michael Johnson',
                'date_of_birth' => '1982-01-15',
                'contact_number' => '3456789012',
                'email' => 'michael@example.com',
                'license_number' => 'D6543210',
                'license_issuing_state' => 'TX',
                'license_expiry_date' => '2027-08-20',
                'vehicle_make_model' => 'Ford F-150',
                'vehicle_registration_number' => 'DEF789',
                'insurance_details' => 'Progressive Insurance, Policy #54321',
                'emergency_contact_name' => 'Sarah Johnson',
                'emergency_contact_number' => '6789012345',
                'emergency_contact_relationship' => 'Wife',
            ],
        ];

        // Insert each driver record into the database
        foreach ($drivers as $driver) {
            Driver::create($driver);
        }
    }
}