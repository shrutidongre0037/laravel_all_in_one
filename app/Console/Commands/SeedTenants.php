<?php

namespace App\Console\Commands;

use App\Models\Marketing;
use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Models\Tenant;
use Database\Seeders\Tenant\DepartmentSeeder;
use Database\Seeders\Tenant\DevelopmentSeeder;
use Database\Seeders\Tenant\MarketingSeeder;
use Database\Seeders\Tenant\ProjectSeeder;


class SeedTenants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all seeders for each tenant database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenants = Tenant::all();
        foreach ($tenants as $tenant) {
            $this->info("⏳ Seeding: {$tenant->name} ({$tenant->database})");

            Config::set('database.connections.tenant.database', $tenant->database);
            DB::purge('tenant');
            DB::reconnect('tenant');
            DB::setDefaultConnection('tenant');

            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--path' => '/database/migrations/tenant',
                '--force' => true,
            ]);

            app(\Faker\Generator::class)->unique(true);

            // Seed all tenant data
            Artisan::call('db:seed', [
                '--class' => DepartmentSeeder::class,
                '--database' => 'tenant',
                '--force' => true
            ]);
        
            Artisan::call('db:seed', [
                '--class' => DevelopmentSeeder::class,
                '--database' => 'tenant',
                '--force' => true
            ]);

            Artisan::call('db:seed', [
                '--class' => MarketingSeeder::class,
                '--database' => 'tenant',
                '--force' => true
            ]);

            Artisan::call('db:seed', [
                '--class' => ProjectSeeder::class,
                '--database' => 'tenant',
                '--force' => true
            ]);
            Artisan::call('db:seed', [
                '--class' => \Database\Seeders\Tenant\TenantDatabaseSeeder::class,
                '--database' => 'tenant',
                '--force' => true
            ]);

            $this->info("Seeded: {$tenant->name}\n");
        }

        $this->info("🎉 All tenant databases have been seeded successfully.");
    }
}
