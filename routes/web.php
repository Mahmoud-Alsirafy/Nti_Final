<?php

use App\Http\Controllers\Google\GoogleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// // Main / Home route
// Route::get('/', function () {
//     return view('dashboard');
// })->name('home');

use App\Http\Controllers\DashboardController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/search-pet', [DashboardController::class, 'searchPet'])->name('dashboard.search-pet');
    Route::post('/dashboard/search-user-qr', [DashboardController::class, 'searchUserByQr'])->name('dashboard.search-user-qr');
    Route::get('/dashboard/search-user-qr/{token?}', [DashboardController::class, 'searchUserByQr'])->name('dashboard.search-user-qr.get');
});

// // Pets Routes
// Route::get('/my-pets', function () {
//     return view('pets.index');
// })->name('pets.index');

// Route::get('/pet-profile', function () {
//     return view('pets.show');
// })->name('pets.show');

// Route::get('/add-pet', function () {
//     return view('pets.create');
// })->name('pets.create');

// // Adoption Routes
// Route::get('/adoption', function () {
//     return view('adoption.index');
// })->name('adoption.index');

// Route::get('/adoption/details', function () {
//     return view('adoption.show');
// })->name('adoption.show');

// Route::get('/adoption/request', function () {
//     return view('adoption.request');
// })->name('adoption.request');

// // Settings Route
// Route::get('/account-settings', function () {
//     return view('settings.account');
// })->name('settings.account');

// // Auth Custom Login View
// Route::get('/login-view', function () {
//     return view('auth.login');
// })->name('login.view');

// Google Auth
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';
