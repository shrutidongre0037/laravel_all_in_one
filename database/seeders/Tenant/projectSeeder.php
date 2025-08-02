<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use App\Models\Project;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['pending', 'In progress', 'completed'];
        $priorities = ['low', 'medium', 'high'];

        // 1. Seed fixed data (9 entries)
        $projects = [
            [
                'id' => Str::uuid(),
                'title' => 'Department Manager',
                'description' => 'An internal system for creating and storing different department records like Development, Marketing, HR in a database.',
                'start_date' => '2025-04-09',
                'end_date' => '2025-05-12',
            ],
            [
                'id' => Str::uuid(),
                'title' => 'Employee Tracker',
                'description' => 'Tool to manage employee attendance, leaves, and performance reports.',
                'start_date' => '2025-05-01',
                'end_date' => '2025-07-01',
            ],
            [
                'id' => Str::uuid(),
                'title' => 'Marketing Campaign Portal',
                'description' => 'Web platform to launch, monitor, and analyze marketing campaigns.',
                'start_date' => '2025-03-15',
                'end_date' => '2025-06-15',
            ],
            [
                'id' => Str::uuid(),
                'title' => 'HR Onboarding System',
                'description' => 'Automated onboarding system for new employees with document uploads and task lists.',
                'start_date' => '2025-01-10',
                'end_date' => '2025-02-28',
            ],
            [
                'id' => Str::uuid(),
                'title' => 'Payroll Integration',
                'description' => 'A system to integrate payroll calculation with attendance and tax deductions.',
                'start_date' => '2025-06-01',
                'end_date' => '2025-08-01',
            ],
            [
                'id' => Str::uuid(),
                'title' => 'Product Inventory System',
                'description' => 'Manage stock, restocking, and vendor tracking for internal products.',
                'start_date' => '2025-03-01',
                'end_date' => '2025-04-15',
            ],
            [
                'id' => Str::uuid(),
                'title' => 'Client Feedback Portal',
                'description' => 'Platform for collecting and analyzing client feedback and ratings.',
                'start_date' => '2025-02-05',
                'end_date' => '2025-03-20',
            ],
            [
                'id' => Str::uuid(),
                'title' => 'Internal Chat App',
                'description' => 'Real-time messaging system for internal team communication.',
                'start_date' => '2025-05-15',
                'end_date' => '2025-06-30',
            ],
            [
                'id' => Str::uuid(),
                'title' => 'Project Planner',
                'description' => 'Tool for creating, assigning, and tracking tasks within multiple projects.',
                'start_date' => '2025-04-20',
                'end_date' => '2025-07-01',
            ],
        ];

        foreach ($projects as &$project) {
            $project['status'] = $statuses[array_rand($statuses)];
            $project['priority'] = $priorities[array_rand($priorities)];
        }

        Project::insert($projects);

        // 2. Seed additional 11 entries using Faker
        $faker = Faker::create();
        for ($i = 0; $i < 511; $i++) {
            Project::create([
                'title' => $faker->sentence(3),
                'description' => $faker->paragraph,
                'start_date' => $faker->dateTimeBetween('-2 months', '+1 month')->format('Y-m-d'),
                'end_date' => $faker->dateTimeBetween('+2 days', '+3 months')->format('Y-m-d'),
                'status' => $statuses[array_rand($statuses)],
                'priority' => $priorities[array_rand($priorities)],
            ]);
        }
    }
}
