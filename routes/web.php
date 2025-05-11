<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\EmployeeController;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });



Route::get('/', function () {
    return Inertia::render('Homepage');
});

Route::inertia('/login', 'Login');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [PageController::class, 'maindashboard'])->name('dashboard');
    Route::get('/employees', [PageController::class, 'employees'])->name('employees');
    Route::get('/inventory', [PageController::class, 'inventory'])->name('inventory');
    Route::get('/attendance', [PageController::class, 'attendance'])->name('attendance');
    Route::get('/history', [PageController::class, 'history'])->name('history');
});


require __DIR__ . '/auth.php';
