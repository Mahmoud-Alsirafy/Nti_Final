<?php

use App\Http\Controllers\Adoption\AdoptionController;
use App\Http\Controllers\Medical\MedicalController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Pet\Per_dataController;
use App\Http\Controllers\Profile\PersonalDataController;
use App\Models\Pet_info;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    // Pet Management
    Route::resource('Pet', Per_dataController::class);
    Route::post('/store_for_adoption', [Per_dataController::class, 'store_for_adoption'])->name('store_for_adoption');

    // Adoption Routes
    Route::get('/adoptions', [AdoptionController::class, 'index'])->name('adoptions.index');
    Route::get('/adoptions/{id}', [AdoptionController::class, 'show'])->name('adoptions.show');
    Route::get('/adoptions/{id}/request', [AdoptionController::class, 'request'])->name('adoptions.request');
    Route::post('/adoptions/{id}/request', [AdoptionController::class, 'new_adoption'])->name('adoptions.request.submit');
    Route::post('/adoptions/{id}/accept', [AdoptionController::class, 'accept'])->name('adoptions.accept');
    Route::post('/adoptions/{id}/reject', [AdoptionController::class, 'reject'])->name('adoptions.reject');

    // Profile & Admin QR
    Route::resource('Profile', PersonalDataController::class);
    Route::get('/admin/qr/regenerate', [PersonalDataController::class, 'regenerate'])->name('admin.qr.regenerate');

    // Appointment Booking
    Route::get('/book-appointment', function () {
        $pets = Pet_info::where('ownerId', Auth::user()->id())->with('images')->get();
        return view('book_appointment', compact('pets'));
    })->name('book_appointment');

    // Medical History & Records
    Route::get('/medical-history/{id?}', [MedicalController::class, 'history'])->name('medical_history');
    Route::get('/medical-record/{pet_id?}', [MedicalController::class, 'record'])->name('medical_record');
    Route::post('/medical-record', [MedicalController::class, 'store'])->name('medical_record.save');

    // Notifications
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark_all_read');
    Route::post('/notifications/send-test', [NotificationController::class, 'sendTest'])->name('notifications.send_test');
});
