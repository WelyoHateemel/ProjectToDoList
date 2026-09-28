<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgrammerController;
use App\Http\Controllers\RoleManagerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $user = auth()->user();

    $role = strtolower(trim($user->role ?? ''));
    $role = str_replace([' ', '_', '-'], '', $role);

    if ($role === 'programmer') {
        return redirect()->route('programmer.index');
    }

    if ($role === 'rolemanager' || $role === 'role') {
        return redirect()->route('rolemanager.index');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Role Manager Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:rolemanager,role'])
    ->prefix('role-manager')
    ->name('rolemanager.')
    ->group(function () {

        // Role Manager dashboard
        Route::get('/', [RoleManagerController::class, 'index'])
            ->name('index');

        // Create task
        Route::post('/tasks', [RoleManagerController::class, 'storeTask'])
            ->name('tasks.store');

        // Update task
        Route::put('/tasks/{task}', [RoleManagerController::class, 'updateTask'])
            ->name('tasks.update');

        // Update task status
        Route::patch('/tasks/{task}/status', [RoleManagerController::class, 'updateStatus'])
            ->name('tasks.status');

        // Delete task
        Route::delete('/tasks/{task}', [RoleManagerController::class, 'destroyTask'])
            ->name('tasks.destroy');
    });


/*
|--------------------------------------------------------------------------
| Programmer Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:programmer'])
    ->prefix('programmer')
    ->name('programmer.')
    ->group(function () {

        // Programmer dashboard
        Route::get('/', [ProgrammerController::class, 'index'])
            ->name('index');

        // Programmer updates task status
        Route::patch('/tasks/{task}/status', [ProgrammerController::class, 'updateStatus'])
            ->name('tasks.status');
    });


/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
