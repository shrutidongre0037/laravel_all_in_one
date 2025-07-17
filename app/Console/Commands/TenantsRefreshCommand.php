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
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            $this->info("Migrating for tenant: {$tenant->name}");

            // Set tenant DB dynamically
            Config::set('database.connections.mysql.database', $tenant->database);
            DB::purge('mysql'); // Clears existing connection
            DB::reconnect('mysql');

            try {
                Artisan::call('migrate:fresh', [
                    '--database' => 'mysql',
                    '--path' => 'database/migrations', // Make sure you use this folder
                    '--force' => true,
                ]);

                $this->info("✅ Migrated: {$tenant->name}");
            } catch (\Exception $e) {
                $this->error("❌ Failed for {$tenant->name}: {$e->getMessage()}");
            }
        }

        return Command::SUCCESS;
    }
}
