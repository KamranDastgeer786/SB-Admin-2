<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Compliance;
use App\Models\User;

class ComplianceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users to use for compliance
        $users = User::all();

        // Create dummy compliance records
        $compliances = [
            [
                'user_id' => $users->random()->id,
                'training_completion' => '2024-08-15',
                'inspection_logs' => 'Completed initial inspection.',
                'fit_testing' => 1,
            ],
            [
                'user_id' => $users->random()->id,
                'training_completion' => '2024-07-22',
                'inspection_logs' => 'Passed routine check.',
                'fit_testing' => 0,
            ],
            [
                'user_id' => $users->random()->id,
                'training_completion' => '2024-06-30',
                'inspection_logs' => 'Inspection done with minor issues.',
                'fit_testing' => 1,
            ],
        ];

        // Insert each compliance into the database
        foreach ($compliances as $compliance) {
            Compliance::create($compliance);
        }
    }
}
