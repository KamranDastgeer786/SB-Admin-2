<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IncidentReportSubmission;
use App\Models\User;

class IncidentReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch users for the `submitted_by` field
        $users = User::all();

        // Create dummy incident report records
        $incidentReports = [
            [
                'incident_date_time' => now(),
                'location' => 'Main Office',
                'description' => 'Incident occurred .',
                'names_individuals_involved' => 'John Doe, Jane Smith',
                'roles_in_incident' => 'Employee, Supervisor',
                'contact_information' => '555-1234',
                'attachments' => null, // File paths or URLs can be added if needed
                'witness_statements' => 'No witnesses available.',
                'submitted_by' => $users->first()->id, // Use the ID of the first user
                'submission_date' => now()->toDateString(),
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'incident_date_time' => now()->subDay(),
                'location' => 'Warehouse',
                'description' => 'Another incident.',
                'names_individuals_involved' => 'Alice Johnson, Bob Brown',
                'roles_in_incident' => 'Manager, Staff',
                'contact_information' => '555-5678',
                'attachments' => null, // File paths or URLs can be added if needed
                'witness_statements' => 'Witnesses are present.',
                'submitted_by' => $users->first()->id, // Use the ID of the second user
                'submission_date' => now()->subDay()->toDateString(),
                'status' => 'Reviewed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
 
        foreach ($incidentReports as $report) {
            IncidentReportSubmission::create($report);
        }
    }
}
