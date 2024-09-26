<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClosureDetail;
use App\Models\IncidentView;

class ClosureDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all incident views to use for closure details
        $incidentViews = IncidentView::all();

        // Create dummy closure detail records
        $closureDetails = [
            [
                'incident_view_id' => $incidentViews->random()->id,
                'closing_date' => '2024-09-01',
                'final_report' => 'Final report incident 1.',
                'resolution_summary' => 'Summary for incident 1.',
            ],
            [
                'incident_view_id' => $incidentViews->random()->id,
                'closing_date' => '2024-09-05',
                'final_report' => 'Final report incident 2.',
                'resolution_summary' => 'Summary for incident 2.',
            ],
            [
                'incident_view_id' => $incidentViews->random()->id,
                'closing_date' => '2024-09-10',
                'final_report' => 'Final report incident 3.',
                'resolution_summary' => 'Summary for incident 3.',
            ],
        ];

        // Insert each closure detail into the database
        foreach ($closureDetails as $detail) {
            ClosureDetail::create($detail);
        }
    }
}
