<?php

use App\Http\Controllers\PrakerinController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return redirect()->route('prakerin.index');
    })->name('dashboard');
    
    // Prakerin routes
    Route::controller(PrakerinController::class)->group(function () {
        Route::get('/prakerin', 'index')->name('prakerin.index');
        Route::get('/prakerin/journal', 'create')->name('prakerin.create');
        Route::post('/prakerin/journal', 'store')->name('prakerin.store');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
