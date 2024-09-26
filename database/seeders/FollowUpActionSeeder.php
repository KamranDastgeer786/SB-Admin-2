<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FollowUpAction;
use App\Models\IncidentView;
use App\Models\User;

class FollowUpActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all incident views and users to use for follow-up actions
        $incidentViews = IncidentView::all();
        $users = User::all();

        // Check if there are incident views and users available
        if ($incidentViews->isEmpty() || $users->isEmpty()) {
            $this->command->info('No incident views or users found to seed follow-up actions.');
            return;
        }

        // Create dummy follow-up action records
        $followUpActions = [
            [
                'incident_view_id' => $incidentViews->random()->id,
                'follow_up_date' => now()->format('Y-m-d'),
                'assigned_user' => $users->random()->id,
                'notes' => 'Initial follow-up ',
            ],
            [
                'incident_view_id' => $incidentViews->random()->id,
                'follow_up_date' => now()->addDays(7)->format('Y-m-d'),
                'assigned_user' => $users->random()->id,
                'notes' => 'Second follow-up.',
            ],
            [
                'incident_view_id' => $incidentViews->random()->id,
                'follow_up_date' => now()->addDays(14)->format('Y-m-d'),
                'assigned_user' => $users->random()->id,
                'notes' => 'Third follow-up ',
            ],
        ];

        // Insert each follow-up action into the database
        foreach ($followUpActions as $followUpAction) {
            FollowUpAction::create($followUpAction);
        }
    }
}
