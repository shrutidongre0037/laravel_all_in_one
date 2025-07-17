<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class projectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects=[
            [
            'title' => 'Department Manager',
            'description' => 'An internal system for creating and storing different department records like Development, Marketing, HR in a database.',
            'start_date' =>'2025-04-09',
            'end_date'=>'2025-05-12'
        ],
            [
                'title' => 'Employee Tracker',
                'description' => 'Tool to manage employee attendance, leaves, and performance reports.',
                'start_date' => '2025-05-01',
                'end_date'   => '2025-07-01',
            ],
            [
                'title' => 'Marketing Campaign Portal',
                'description' => 'Web platform to launch, monitor, and analyze marketing campaigns.',
                'start_date' => '2025-03-15',
                'end_date'   => '2025-06-15',
            ],
            [
                'title' => 'HR Onboarding System',
                'description' => 'Automated onboarding system for new employees with document uploads and task lists.',
                'start_date' => '2025-01-10',
                'end_date'   => '2025-02-28',
            ],
            [
                'title' => 'Payroll Integration',
                'description' => 'A system to integrate payroll calculation with attendance and tax deductions.',
                'start_date' => '2025-06-01',
                'end_date'   => '2025-08-01',
            ],
            [
                'title' => 'Product Inventory System',
                'description' => 'Manage stock, restocking, and vendor tracking for internal products.',
                'start_date' => '2025-03-01',
                'end_date'   => '2025-04-15',
            ],
            [
                'title' => 'Client Feedback Portal',
                'description' => 'Platform for collecting and analyzing client feedback and ratings.',
                'start_date' => '2025-02-05',
                'end_date'   => '2025-03-20',
            ],
            [
                'title' => 'Internal Chat App',
                'description' => 'Real-time messaging system for internal team communication.',
                'start_date' => '2025-05-15',
                'end_date'   => '2025-06-30',
            ],
            [
                'title' => 'Project Planner',
                'description' => 'Tool for creating, assigning, and tracking tasks within multiple projects.',
                'start_date' => '2025-04-20',
                'end_date'   => '2025-07-01',
            ],
        ];
         foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
