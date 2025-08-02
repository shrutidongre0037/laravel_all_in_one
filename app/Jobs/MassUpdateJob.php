<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MassUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $module, $column, $value,$tenantDb;

    public function __construct($module, $column, $value,$tenantDb)
    {
        $this->module = $module;
        $this->column = $column;
        $this->value = $value;
        $this->tenantDb = $tenantDb;
    }

    public function handle()
    {
        if (class_exists(\Laravel\Telescope\Telescope::class)) {
        \Laravel\Telescope\Telescope::stopRecording();
    }
        config(['database.connections.tenant.database' => $this->tenantDb]);
        DB::purge('tenant');
        DB::reconnect('tenant');
        // DB::connection('tenant');

        $modelClass = '\\App\\Models\\' . ucfirst($this->module);
 if (!class_exists($modelClass)) {
            Log::error("MassUpdateJob: Model {$modelClass} does not exist.");
            return;
        }

        try {
            // Create instance and run update on proper connection
            $modelInstance = new $modelClass();
            $modelInstance->setConnection('tenant');

            // Force query from model instance to respect scopes
            $updated = $modelInstance->newQuery()->update([
                $this->column => $this->value,
            ]);

            Log::info("MassUpdateJob: Updated {$updated} rows in {$this->tenantDb}.{$this->module} - set {$this->column} = {$this->value}");
        } catch (\Exception $e) {
            Log::error("MassUpdateJob failed: " . $e->getMessage());
        }
    }
}