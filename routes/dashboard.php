<?php

use App\Http\Controllers\Admin\Add_petController;
use App\Http\Controllers\Admin\PersonalDataController;
use App\Http\Controllers\Adoption\AdoptionController;
use App\Http\Controllers\Pet\Per_dataController;
use App\Http\Controllers\User\User_dataController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', CheckRole::class . ':user'])->prefix('User')->group(function () {
    Route::get('/', function () {
        return "user";
    })->name("UserDashboard");
    Route::resource('User_Profile', User_dataController::class);
    Route::resource('Pet', Per_dataController::class);

    Route::post('/user/qr/regenerate', [User_dataController::class, 'regenerate'])
        ->name('user.qr.regenerate');
});

Route::middleware(['auth', CheckRole::class . ':admin'])->prefix('Admin')->group(function () {
    Route::get('/', function () {
        return "Admin";
    })->name("AdminDashboard");

    Route::resource('Profile', PersonalDataController::class);
    Route::resource('Add_pet', Add_petController::class);
    Route::post('/admin/qr/regenerate', [PersonalDataController::class, 'regenerate'])
        ->name('admin.qr.regenerate');
});


Route::get('/adoptions', [AdoptionController::class, 'index'])->name('adoptions.index');
Route::post('/new_adoption', [AdoptionController::class, 'new_adoption'])->name('new_adoption');


// Route::get('/', function () {
//     return view('pets.index');
// })->name('home');

// Route::get('/my-pets', function () {
//     return view('pets.index');
// })->name('pets.index');

// Route::get('/add-pet', function () {
//     return view('pets.create');
// })->name('pets.create');

// Route::get('/adoption/details', function () {
//     return view('adoption.show');
// })->name('adoption.show');

// Route::get('/adoption/request', function () {
//     return view('adoption.request');
// })->name('adoption.request');

// Route::get('/account-settings', function () {
//     return view('settings.account');
// })->name('settings.account');