<?php


use App\Http\Controllers\Profile\PersonalDataController;
use App\Http\Controllers\Adoption\AdoptionController;
use App\Http\Controllers\Pet\Per_dataController;


use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {


    Route::resource('Pet', Per_dataController::class);


    Route::get('/adoptions', [AdoptionController::class, 'index'])->name('adoptions.index');
    Route::post('/new_adoption', [AdoptionController::class, 'new_adoption'])->name('new_adoption');
    Route::resource('Profile', PersonalDataController::class);
    Route::get('/admin/qr/regenerate', [PersonalDataController::class, 'regenerate'])
        ->name('admin.qr.regenerate');
});





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
