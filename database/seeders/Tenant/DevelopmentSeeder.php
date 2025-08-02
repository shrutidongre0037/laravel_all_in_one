<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Development;
use App\Models\Department;
use Illuminate\Support\Str;

class DevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = Department::all();

        // If there are no departments, exit early
        if ($departments->isEmpty()) {
            $this->command->warn('No departments found. Skipping development seeding.');
            return;
        }

        Development::factory()
    ->count(500)
    ->create()
    ->each(function ($development) use ($departments) {
        $selectedDepartments = $departments->random(rand(1,1));

        foreach ($selectedDepartments as $department) {
            $development->departments()->attach($department->id, [
                'id' => (string) Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    });
    }
}
