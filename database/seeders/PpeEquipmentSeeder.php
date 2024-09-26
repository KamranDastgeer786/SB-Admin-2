<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PpeEquipment;

class PpeEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define dummy PPE equipment records
        $ppeEquipments = [
            [
                'equipment_name' => 'Safety Helmet',
                'equipment_type' => 'Head Protection',
                'serial_number' => 'SH-12345',
                'date_of_purchase' => '2022-01-15',
            ],
            [
                'equipment_name' => 'Safety Goggles',
                'equipment_type' => 'Eye Protection',
                'serial_number' => 'SG-67890',
                'date_of_purchase' => '2021-11-10',
            ],
            [
                'equipment_name' => 'High-Visibility Vest',
                'equipment_type' => 'Body Protection',
                'serial_number' => 'HV-54321',
                'date_of_purchase' => '2023-03-05',
            ],
        ];

        // Insert records into the database
        foreach ($ppeEquipments as $ppe) {
            PpeEquipment::create($ppe);
        }
    }
}