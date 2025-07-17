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

        Config::set('database.connections.tenant.database', $dbName);
        DB::purge('tenant');
        DB::reconnect('tenant');
        Artisan::call('migrate', ['--force' => true]);
        $this->info("Tenant created successfully with database: $dbName");
    }
}
