<?php

use App\Http\Controllers\Adoption\AdoptionController;
use Illuminate\Support\Facades\Route;




Route::get('/adoption', [AdoptionController::class, 'index'])->name('adoptions.index');
Route::post('/new_adoption', [AdoptionController::class, 'new_adoption'])->name('new_adoption');
Route::post('/store_for_adoption', [AdoptionController::class, 'store_for_adoption'])->name('store_for_adoption');


// show the pet for adoption by owner
Route::get('/adoption_status/{owner_id}', [AdoptionController::class, 'adoption_status'])->name('adoption_status');
