<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TenantAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenantA = Tenant::create([
            'name' => 'Main company',
            'database' => 'db_rest',
        ]);

        User::create([
            'name' => 'Main Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'tenant_id' => $tenantA->id,
            'role' => 'admin',
        ]);

        $tenantB = Tenant::create([
            'name' => 'Company A',
            'database' => 'db_rest_company1',
        ]);

        User::create([
            'name' => 'Admin A',
            'email' => 'admin@companya.com',
            'password' => Hash::make('adminCA1'),
            'tenant_id' => $tenantB->id,
            'role' => 'admin',
        ]);

        $tenantC = Tenant::create([
            'name' => 'Company B',
            'database' => 'db_rest_company2',
        ]);

        User::create([
            'name' => 'Admin B',
            'email' => 'admin@companyb.com',
            'password' => Hash::make('adminCB1'),
            'tenant_id' => $tenantC->id,
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'HR Company B',
            'email' => 'hr@companyb.com',
            'password' => Hash::make('hr@12345'),
            'tenant_id' => $tenantC->id,
            'role' => 'hr',
        ]);

        $tenantD = Tenant::create([
            'name' => 'Company C',
            'database' => 'db_rest_company3',
        ]);

        User::create([
            'name' => 'Admin C',
            'email' => 'admin@companyc.com',
            'password' => Hash::make('adminCC1'),
            'tenant_id' => $tenantD->id,
            'role' => 'admin',
        ]);

         
    }
}
