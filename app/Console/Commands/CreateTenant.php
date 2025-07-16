<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;



class CreateTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new tenant';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $dbName = 'db_rest_' . strtolower($name);
        DB::statement("CREATE DATABASE $dbName");

        $tenant = Tenant::create([
            'name' => $name,
            'database' => $dbName,
        ]);

        Config::set('database.connections.mysql.database', $dbName);
        DB::purge('mysql');
        Artisan::call('migrate', ['--force' => true]);

        User::create([
            'name' => 'Admin ' . $name,
            'email' => 'admin@' . strtolower($name) . '.com',
            'password' => Hash::make('password'),
            'tenant_id' => $tenant->id,
            'role' => 'admin'
        ]);
        Artisan::call('db:seed', [
            '--class' => 'TenantSeeder',
            '--force' => true
        ]);
        $this->info("Tenant created successfully with database: $dbName");
    }
}
