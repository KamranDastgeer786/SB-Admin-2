<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserAssignment;
use App\Models\PpeEquipment;
use App\Models\User;

class UserAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch sample users and PPE equipment
        $users = User::all();
        $ppeEquipments = PpeEquipment::all();
 
        // Define dummy user assignment records
        $assignments = [
            [
                'user_id' => $users->random()->id,
                'pp_assigned' => $ppeEquipments->random()->id,
                'assignment_date' => '2024-09-15',
            ],
            [
                'user_id' => $users->random()->id,
                'pp_assigned' => $ppeEquipments->random()->id,
                'assignment_date' => '2024-09-16',
            ],
            [
                'user_id' => $users->random()->id,
                'pp_assigned' => $ppeEquipments->random()->id,
                'assignment_date' => '2024-09-17',
            ],
        ];
 
        // Insert records into the database
        foreach ($assignments as $assignment) {
            UserAssignment::create($assignment);
        }
    }
}
