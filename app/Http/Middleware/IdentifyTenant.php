<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;


class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check())
        {
            $tenant=Auth::User()->tenant;
            if(!$tenant)
            {
                abort(403,'No tenant Assigned');
            }
            //for setup for dynammic tenant DB
            Config::set('database.connections.tenant.database',$tenant->database);
            DB::purge('tenant');
            DB::reconnect('tenant');
            DB::setDefaultConnection('tenant');
            if (app()->environment('local', 'testing')) {
                 Log::info('Switched to tenant DB: ' . $tenant->database);
            }

        }
        return $next($request);
    }
}
