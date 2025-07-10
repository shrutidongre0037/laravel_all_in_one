<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        // HR user
        User::create([
            'name' => 'HR',
            'email' => 'hr@gmail.com',
            'password' => Hash::make('hr@12345'),
            'role' => 'hr'
        ]);
    }
}
