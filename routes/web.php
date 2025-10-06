<?php

use App\Http\Controllers\PricesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RepairsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('/dashboard', [RepairsController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(callback: function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/repairs', [RepairsController::class, 'index'])->name('repairs.get');
    Route::post('/repair/create', [RepairsController::class, 'store'])->name('repair.store');
    Route::post('/repair/update/{repair}', [RepairsController::class, 'update'])->name('repair.update');
    Route::delete('/repair/delete/{repair}', [RepairsController::class, 'destroy'])->name('repair.delete');
    Route::get('/fetch/repairs', [RepairsController::class, 'sortAndFilter'])->name('repair.sort.filter');

    Route::get('/prices', [PricesController::class, 'index'])->name('prices.get');
    Route::patch('/repair/update/status/{repair}', [RepairsController::class, 'updateStatus'])->name('repair.status.update');
});

require __DIR__.'/auth.php';
