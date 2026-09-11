<?php


use App\Http\Controllers\Profile\PersonalDataController;
use App\Http\Controllers\Adoption\AdoptionController;
use App\Http\Controllers\Pet\Per_dataController;
use App\Http\Controllers\Notification\NotificationController;

use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {


    Route::resource('Pet', Per_dataController::class);
    Route::post('/store_for_adoption', [Per_dataController::class, 'store_for_adoption'])->name('store_for_adoption');

    // Adoption Routes
    Route::get('/adoptions', [AdoptionController::class, 'index'])->name('adoptions.index');
    Route::get('/adoption', [AdoptionController::class, 'index'])->name('adoption.index');
    Route::get('/adoptions/{id}', [AdoptionController::class, 'show'])->name('adoptions.show');
    Route::get('/adoption/{id}', [AdoptionController::class, 'show'])->name('adoption.show');
    Route::get('/adoptions/{id}/request', [AdoptionController::class, 'request'])->name('adoptions.request');
    Route::get('/adoption/{id}/request', [AdoptionController::class, 'request'])->name('adoption.request');
    Route::post('/adoptions/{id}/request', [AdoptionController::class, 'new_adoption'])->name('adoptions.request.submit');
    Route::post('/new_adoption', [AdoptionController::class, 'new_adoption'])->name('new_adoption');

    Route::resource('Profile', PersonalDataController::class);
    Route::get('/admin/qr/regenerate', [PersonalDataController::class, 'regenerate'])
        ->name('admin.qr.regenerate');

    // Appointment Booking Routes
    Route::get('/book-appointment', function () {
        $pets = \App\Models\Pet_info::where('ownerId', auth()->id())->with('images')->get();
        return view('book_appointment', compact('pets'));
    })->name('book_appointment');
    Route::get('/book_appointment', function () {
        return redirect()->route('book_appointment');
    });

    // Medical History Routes (handled by MedicalController)
    Route::get('/medical-history/{id?}', [\App\Http\Controllers\Medical\MedicalController::class, 'history'])->name('medical_history');
    Route::get('/medical_history/{id?}', function ($id = null) {
        return redirect()->route('medical_history', $id ? ['id' => $id] : []);
    });

    // Medical Record Routes (handled by MedicalController)
    Route::get('/medical-record/{pet_id?}', [\App\Http\Controllers\Medical\MedicalController::class, 'record'])->name('medical_record');
    Route::get('/medical_record/{pet_id?}', function ($pet_id = null) {
        return redirect()->route('medical_record', $pet_id ? ['pet_id' => $pet_id] : []);
    });
    Route::post('/medical-record', [\App\Http\Controllers\Medical\MedicalController::class, 'store'])->name('medical_record.save');

    // Notifications Routes handled by NotificationController
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark_all_read');
    Route::post('/notifications/send-test', [NotificationController::class, 'sendTest'])->name('notifications.send_test');
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
