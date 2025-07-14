<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('custom:clear', function () {
    $this->call('config:clear');  // clear config cache
    $this->call('route:clear');   // clear route cache
    $this->call('cache:clear');   // clear app cache
    $this->call('view:clear');   // clear view cache
    $this->info('All cleared successfully!');
})->purpose('Clear config, route, cache and view');