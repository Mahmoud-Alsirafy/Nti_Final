<?php

use App\Http\Controllers\Pet\Per_dataController;
use App\Http\Controllers\Admin\PersonalDataController;
use App\Http\Controllers\Admin\Add_petController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', CheckRole::class . ':user'])->prefix('User')->group(function () {
    Route::get('/', function () {
        return "user";
    })->name("UserDashboard");
    Route::resource('Pet', Per_dataController::class);
});

Route::middleware(['auth', CheckRole::class . ':admin'])->prefix('Admin')->group(function () {
    Route::get('/', function () {
        return "Admin";
    })->name("AdminDashboard");

    Route::resource('Profile', PersonalDataController::class);
    Route::resource('Add_pet', Add_petController::class);
});