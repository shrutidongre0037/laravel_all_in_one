<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Development;
use Illuminate\Support\Facades\Mail;

class SendDevelopmentNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $development;
    /**
     * Create a new job instance.
     */
    public function __construct(Development $development)
    {
        $this->development=$development;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::raw('New Development Created : ' . $this->development->name,function($message){
            $message->to('admin@gmail.com')
                    ->subject('New development data created');
        });
    }
}
