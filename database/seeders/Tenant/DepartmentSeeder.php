<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $departments = [
            'Web Developer',
            'Android Developer',
            'iOS Developer',
        ];

        foreach ($departments as $dept) {
            Department::factory()->create([
                'name' => $dept,
            ]);
        }
    }
}
