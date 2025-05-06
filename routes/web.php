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


Route::get('/dashboard', [PageController::class, 'maindashboard']);
Route::get('/employees', [PageController::class, 'employees']);
Route::get('/inventory', [PageController::class, 'inventory']);
Route::get('/attendance', [PageController::class, 'attendance']);
Route::get('/history', [PageController::class, 'history']);

Route::get('/', function () {
    return Inertia::render('Homepage');
});

Route::inertia('/login', 'Login');

//)->middleware(['auth', 'verified'])->name('Employees') Pang authenticate daw

Route::resource('employees', EmployeeController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
