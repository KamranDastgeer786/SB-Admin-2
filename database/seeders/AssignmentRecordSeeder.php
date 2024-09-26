<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssignmentRecord;
use App\Models\PpeEquipment;
use App\Models\User;

class AssignmentRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch random PPE equipment and user to assign
        $ppeEquipments = PpeEquipment::all();
        $users = User::all();

        // Create dummy assignment records
        $assignmentRecords = [
            [
                'ppe_equipment_id' => $ppeEquipments->random()->id,
                'assigned_to' => $users->random()->id,
                'date_of_assignment' => now(),
                'ppe_condition' => 'Good',
                'maintenance_due_date' => now()->addMonths(6),
            ],
            [
                'ppe_equipment_id' => $ppeEquipments->random()->id,
                'assigned_to' => $users->random()->id,
                'date_of_assignment' => now(),
                'ppe_condition' => 'Fair',
                'maintenance_due_date' => now()->addMonths(3),
            ],
            [
                'ppe_equipment_id' => $ppeEquipments->random()->id,
                'assigned_to' => $users->random()->id,
                'date_of_assignment' => now(),
                'ppe_condition' => 'Excellent',
                'maintenance_due_date' => now()->addYear(),
            ],
        ];

        foreach ($assignmentRecords as $record) {
            AssignmentRecord::create($record);
        }
    }
}