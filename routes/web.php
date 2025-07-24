<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Custom_Controller\DepartmentController;
use App\Http\Controllers\Custom_Controller\DevelopmentController;
use App\Http\Controllers\Custom_Controller\MarketingController;
use App\Http\Controllers\Custom_Controller\ProjectController;
use App\Models\Department;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use Barryvdh\Debugbar\Facades\Debugbar;

Route::get('/debugbar-test', function () {
    Debugbar::addMessage('Hello from route');
    Debugbar::info(['test' => true]);

    return view('welcome'); // Use the default Blade view
});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'role:admin,hr'])->group(function () {
    Route::get('/dashboard', function () {
         $user = Auth::user();

        // if (!in_array($user->role, ['admin', 'hr', 'development'])) {
        //     abort(403, 'Unauthorized');
        // }

        $departmentCount = null;
        $developmentCount = null;
        $marketingCount = null;
        $projectCount = null;

        if ($user->tenant_id) {
            // Only count if user is linked to a tenant
            $departmentCount = $user->role === 'admin' ? \App\Models\Department::count() : null;
            $developmentCount = \App\Models\Development::count();
            $marketingCount = \App\Models\Marketing::count();
            $projectCount = \App\Models\Project::count();
        }

        return view('dashboard', compact(
            'departmentCount',
            'developmentCount',
            'marketingCount',
            'projectCount'
        ));
    })->name('dashboard');

    //department resource
    Route::resource('departments', DepartmentController::class)->except(['show']);
    Route::get('departments/trashed-data', [DepartmentController::class, 'trashedData'])->name('departments.trashed.data');
    Route::patch('departments/{id}/restore', [DepartmentController::class, 'restore'])->name('departments.restore');
    Route::delete('departments/{id}/force-delete', [DepartmentController::class, 'forceDeleted'])->name('departments.forceDeleted');

    //development resource
    Route::get('/developments/trashed-data', [DevelopmentController::class, 'trashedData'])->name('developments.trashed.data');

    Route::resource('developments', DevelopmentController::class);
    Route::get('/developments/data', [DevelopmentController::class, 'getDevelopment'])->name('developments.data');
    Route::patch('developments/{id}/restore', [DevelopmentController::class, 'restore'])->name('developments.restore');
    Route::delete('developments/{id}/force-delete', [DevelopmentController::class, 'forceDeleted'])->name('developments.forceDeleted');


    //marketing resource
    Route::get('marketing/trashed-data', [MarketingController::class, 'trashedData'])->name('marketing.trashed.data');
    Route::resource('marketings', MarketingController::class);
    Route::get('/get-marketing-data', [MarketingController::class, 'getMarketing'])->name('marketing.data');
    Route::patch('marketings/{id}/restore', [MarketingController::class, 'restore'])->name('marketings.restore');
    Route::delete('marketings/{id}/force-delete', [MarketingController::class, 'forceDeleted'])->name('marketings.forceDeleted');

    //projects resources
    Route::get('projects/trashed-data', [ProjectController::class, 'trashedData'])->name('projects.trashed.data');
    Route::get('/projects-data', [ProjectController::class, 'getProject'])->name('projects.data');
    Route::resource('projects', ProjectController::class);
    Route::patch('projects/{id}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
    Route::delete('projects/{id}/force-delete', [ProjectController::class, 'forceDeleted'])->name('projects.forceDeleted');

 
    
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
});

Route::middleware('auth')->group(function () {
    Route::resource('developments', DevelopmentController::class);
    Route::get('/devlopments', [DevelopmentController::class, 'index'])->name('devlopments.index');
    Route::get('/devlopments/data', [DevelopmentController::class, 'getDevelopment'])->name('developments.data');
    Route::patch('developments/{id}/restore', [DevelopmentController::class, 'restore'])->name('developments.restore');
    Route::delete('developments/{id}/force-delete', [DevelopmentController::class, 'forceDeleted'])->name('developments.forceDeleted');
});

Route::middleware('auth')->group(function () {
    Route::resource('marketings', MarketingController::class);
    Route::patch('marketings/{id}/restore', [MarketingController::class, 'restore'])->name('marketings.restore');
    Route::delete('marketings/{id}/force-delete', [MarketingController::class, 'forceDeleted'])->name('marketings.forceDeleted');
});
require __DIR__.'/auth.php';
