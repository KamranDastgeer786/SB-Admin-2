<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define modules and operations
        $modules = [
            'users', 
            'media', 
            'incidentReports', 
            'drivers', 
            'ppeEquipments', 
            'assignmentRecords', 
            'onboardingRecords', 
            'driver_profiles', 
            'assignments', 
            'performance_records', 
            'incident_views', 
            'follow_up_actions', 
            'closure_details',
            'inventories',
            'user_assignments',
            'compliances',
            'roles', 
            'permissions'
        ];
        $operations = ['create', 'edit', 'delete', 'show'];

        // Loop through modules and operations to create permissions
        foreach ($modules as $module) {
            foreach ($operations as $operation) {
                // Construct permission name
                $permissionName = $operation . '_' . $module;

                // Check if permission already exists
                if (!Permission::where('name', $permissionName)->exists()) {
                    // Create new permission if it does not exist
                    Permission::create([
                        'name' => $permissionName,
                    ]);
                }
            }
        }
    }
}