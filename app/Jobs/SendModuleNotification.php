<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SendModuleNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $model;
    protected $moduleName;
    /**
     * Create a new job instance.
     */
    public function __construct($model, string $moduleName)
    {
         $this->model = $model;
        $this->moduleName = $moduleName;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Config::set('mail.default', 'log');

        $messageBody = "New {$this->moduleName} Created: " . ($this->model->name ?? 'N/A');

        Mail::raw($messageBody, function ($message) {
            $message->to('admin@gmail.com')
                    ->subject("New {$this->moduleName} Data Created");
        });
    }
}
