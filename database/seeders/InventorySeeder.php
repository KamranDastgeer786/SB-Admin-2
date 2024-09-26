<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inventory;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define dummy inventory records
        $inventories = [
            [
                'total_equipment' => 100,
                'available_stock' => 80,
                'maintenance_schedule' => '2024-10-01',
            ],
            [
                'total_equipment' => 150,
                'available_stock' => 120,
                'maintenance_schedule' => '2024-11-15',
            ],
            [
                'total_equipment' => 200,
                'available_stock' => 190,
                'maintenance_schedule' => '2024-12-01',
            ],
        ];

        // Insert records into the database
        foreach ($inventories as $inventory) {
            Inventory::create($inventory);
        }
    }
}
