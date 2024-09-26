<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            MediaSeeder::class,
            IncidentReportSeeder::class,
            DriverSeeder::class,
            PpeEquipmentSeeder::class,
            AssignmentRecordSeeder::class,
            OnboardingRecordSeeder::class,
            DriverProfileSeeder::class,
            AssignmentSeeder::class,
            PerformanceRecordSeeder::class,
            IncidentViewSeeder::class,
            FollowUpActionSeeder::class,
            ClosureDetailSeeder::class,
            InventorySeeder::class,
            UserAssignmentSeeder::class,
            ComplianceSeeder::class,
            DefaultRoleSeeder::class,

        ]);
    }
}
