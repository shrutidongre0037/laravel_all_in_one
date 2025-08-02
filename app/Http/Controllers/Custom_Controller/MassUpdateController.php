<?php
namespace App\Http\Controllers\Custom_Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\MassUpdateJob;
use Illuminate\Support\Facades\Log;

class MassUpdateController extends Controller
{
    public function handle(Request $request)
    {
        $request->validate([
            'module' => 'required|string',
            'column' => 'required|string',
            'value' => 'required',
        ]);

        $module = $request->input('module');
        $column = $request->input('column');
        $value = $request->input('value');
        Log::info("Dispatching MassUpdateJob for {$module} - Column: {$column}, Value: {$value}");
        // Dispatching the job
        $tenantDb = auth()->user()->tenant->database;
        // dd(MassUpdateJob::dispatch   ($module, $column, $value, $tenantDb));
        MassUpdateJob::dispatch($module, $column, $value, $tenantDb);


        return redirect()->back()->with('success', 'Mass update job dispatched!');
    }
}


