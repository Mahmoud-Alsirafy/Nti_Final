<?php

use App\Http\Controllers\Adoption\AdoptionController;
use Illuminate\Support\Facades\Route;




Route::get('/adoptions', [AdoptionController::class, 'index'])->name('adoptions.index');
Route::post('/new_adoption', [AdoptionController::class, 'new_adoption'])->name('new_adoption');