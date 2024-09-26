<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OnboardingRecord;
use App\Models\User;

class OnboardingRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch random users
        $users = User::all();

        // Create dummy onboarding records
        $onboardingRecords = [
            [
                'user_id' => $users->random()->id,
                'ppe_training_completion_date' => now()->subMonths(1), // 1 month ago
                'ppe_fit_testing' => true,
            ],
            [
                'user_id' => $users->random()->id,
                'ppe_training_completion_date' => now()->subWeeks(2), // 2 weeks ago
                'ppe_fit_testing' => false,
            ],
            [
                'user_id' => $users->random()->id,
                'ppe_training_completion_date' => now(), // Today
                'ppe_fit_testing' => true,
            ],
        ];

        // Insert records into the database
        foreach ($onboardingRecords as $record) {
            OnboardingRecord::create($record);
        }
    }
}