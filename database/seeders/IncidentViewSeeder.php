<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IncidentView;
use App\Models\User;

class IncidentViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users to use for assigning reviewers
        $users = User::all();

        // Create dummy incident view records
        $incidentViews = [
            [
                'date_time' => now()->format('Y-m-d H:i:s'),
                'status' => 'Pending',
                'assigned_reviewer' => $users->random()->id,
            ],
            [
                'date_time' => now()->addDay()->format('Y-m-d H:i:s'),
                'status' => 'Reviewed',
                'assigned_reviewer' => $users->random()->id,
            ],
            [
                'date_time' => now()->addDays(2)->format('Y-m-d H:i:s'),
                'status' => 'Closed',
                'assigned_reviewer' => $users->random()->id,
            ],
        ];

        // Insert each incident view into the database
        foreach ($incidentViews as $incidentView) {
            IncidentView::create($incidentView);
        }
    }
}
