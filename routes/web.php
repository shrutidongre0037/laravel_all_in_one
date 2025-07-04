<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Custom_Controller\DepartmentController;
use App\Http\Controllers\Custom_Controller\DevelopmentController;
use App\Http\Controllers\Custom_Controller\MarketingController;
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

Route::get('/', function () {
    return view('welcome');
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

        return view('dashboard',[
            'departmentCount' => $user->role === 'admin' ? \App\Models\Department::count() : null,
            'developmentCount' => \App\Models\Development::count(),
            'marketingCount' => \App\Models\Marketing::count(),

        ]);
    })->name('dashboard');

    //department resource
    Route::resource('departments', DepartmentController::class);

    //development resource
    Route::resource('developments', DevelopmentController::class);
    Route::get('/devlopments', [DevelopmentController::class, 'index'])->name('devlopments.index');
    Route::get('/devlopments/data', [DevelopmentController::class, 'getDevelopment'])->name('developments.data');
    Route::patch('developments/{id}/restore', [DevelopmentController::class, 'restore'])->name('developments.restore');
    Route::delete('developments/{id}/force-delete', [DevelopmentController::class, 'forceDeleted'])->name('developments.forceDeleted');

    //marketing resource
    Route::resource('marketings', MarketingController::class);
    Route::patch('marketings/{id}/restore', [MarketingController::class, 'restore'])->name('marketings.restore');
    Route::delete('marketings/{id}/force-delete', [MarketingController::class, 'forceDeleted'])->name('marketings.forceDeleted');
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
