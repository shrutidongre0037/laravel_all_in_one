<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class TenantsRefreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations for all tenant databases';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ensure main database has tenants table
        $this->info("Migrating central database...");
        Artisan::call('migrate', ['--database' => 'mysql', '--force' => true]);

        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            $this->info("Refreshing : {$tenant->name}");

            // Set tenant DB dynamically
            Config::set('database.connections.tenant.database', $tenant->database);
            DB::purge('tenant'); // Clears existing connection
            DB::reconnect('tenant');
            DB::setDefaultConnection('tenant');

            try {
                Artisan::call('migrate:fresh', [
                    '--database' => 'tenant',
                    '--path' => 'database/migrations/tenant', 
                    '--force' => true,
                ]);
                Artisan::call('db:seed', [
                '--class' => \Database\Seeders\Tenant\TenantDatabaseSeeder::class,
                '--database' => 'tenant',
                '--force' => true,
            ]);

                $this->info("✅ Refreshed: {$tenant->name}");
            } catch (\Exception $e) {
                $this->error("❌ Failed for {$tenant->name}: {$e->getMessage()}");
            }
        }

        return Command::SUCCESS;
    }
}
