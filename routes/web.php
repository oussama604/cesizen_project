<?php

use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\Admin\StressEventController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\BreathingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StressDiagnosticController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('information.index');
})->name('home');

Route::get('/informations', [InformationController::class, 'index'])->name('information.index');
Route::get('/informations/{slug}', [InformationController::class, 'show'])->name('information.show');

Route::get('/dashboard', DashboardController::class)->middleware(['auth'])->name('dashboard');

Route::get('/diagnostic-stress', [StressDiagnosticController::class, 'create'])->name('diagnostics.create');
Route::post('/diagnostic-stress', [StressDiagnosticController::class, 'store'])->name('diagnostics.store');
Route::get('/respiration-guidee', [BreathingController::class, 'show'])->name('breathing.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/mes-diagnostics', [StressDiagnosticController::class, 'history'])->name('diagnostics.history');
    Route::post('/respiration-sessions', [BreathingController::class, 'store'])->name('breathing.store');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'can:access-admin-panel'])->group(function () {
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');

    Route::resource('contents', AdminContentController::class)->except('show');
    Route::resource('stress-events', StressEventController::class)->except('show');
});

require __DIR__.'/auth.php';
