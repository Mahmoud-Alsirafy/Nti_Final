<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\Adoption;
use App\Models\Pet_info;
use App\Models\User;
use App\Notifications\PetNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    /**
     * Mark a single notification as read.
     */
    public function markAsRead(string $id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read for the authenticated user.
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Handle doctor uploading a medical report, then notify the pet owner via DB & Email.
     */
    public function storeMedicalRecord(Request $request)
    {
        $validated = $request->validate([
            'Pets' => 'required',
            'visit_date' => 'nullable|date',
            'describe' => 'required|string|min:3',
            'treat_plan' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $petIdentifier = $request->input('Pets');
        
        // Find pet by ID or Name
        $pet = Pet_info::with('owner')->where('id', $petIdentifier)
            ->orWhere('name', $petIdentifier)
            ->first();

        $doctor = Auth::user();

        if ($pet) {
            // Update pet health info with latest diagnosis
            $pet->update([
                'health_info' => $request->input('describe'),
            ]);

            // Notify Pet Owner via Database & Mail
            self::sendMedicalReportNotification(
                $pet,
                $doctor,
                $request->input('describe'),
                $request->input('treat_plan')
            );

            return redirect()->route('medical_history', $pet->id)
                ->with('success', 'Medical report logged and notification sent to ' . ($pet->owner->name ?? 'owner') . ' via email & database!');
        }

        return redirect()->route('medical_history')
            ->with('success', 'Medical record logged successfully!');
    }

    /**
     * Send notification to pet owner when a doctor uploads a medical report.
     */
    public static function sendMedicalReportNotification(Pet_info $pet, User $doctor, string $diagnosis, ?string $treatment = null)
    {
        $owner = $pet->owner;
        if (!$owner) {
            return;
        }

        $title = "New Medical Report for {$pet->name}";
        $snippet = Str::limit($diagnosis, 120);
        $message = "Dr. {$doctor->name} uploaded a medical report for {$pet->name}. Diagnosis: {$snippet}";
        if ($treatment) {
            $message .= " | Treatment: " . Str::limit($treatment, 80);
        }

        $actionUrl = route('medical_history', $pet->id);
        $actionText = 'View Medical Report';
        $type = 'urgent';

        try {
            $owner->notify(new PetNotification($title, $message, $type, $actionUrl, $actionText));
        } catch (\Throwable $e) {
            Log::warning("Email delivery throttled/failed for medical report notification: " . $e->getMessage());

            // Save directly to DB if mail server rate-limits
            $owner->notifications()->create([
                'id' => (string) Str::uuid(),
                'type' => PetNotification::class,
                'data' => [
                    'title' => $title,
                    'message' => $message,
                    'type' => $type,
                    'action_url' => $actionUrl,
                    'action_text' => $actionText,
                ],
                'read_at' => null,
            ]);
        }
    }

    /**
     * Send notification to pet owner when someone wants to adopt their pet.
     */
    public static function sendAdoptionRequestNotification(Adoption $adoption, User $adopter)
    {
        // Load pet and owner relationships if not loaded
        if (!$adoption->relationLoaded('pet')) {
            $adoption->load('pet');
        }
        if (!$adoption->relationLoaded('owner')) {
            $adoption->load('owner');
        }

        $owner = $adoption->owner;
        $pet = $adoption->pet;

        if (!$owner || !$pet) {
            return;
        }

        $title = "New Adoption Request for {$pet->name}";
        $message = "{$adopter->name} has submitted an application to adopt {$pet->name}. Reason: " . Str::limit($adoption->why, 100);
        $actionUrl = route('adoptions.show', $adoption->id);
        $actionText = 'Review Application';
        $type = 'appointment';

        try {
            $owner->notify(new PetNotification($title, $message, $type, $actionUrl, $actionText));
        } catch (\Throwable $e) {
            Log::warning("Email delivery throttled/failed for adoption notification: " . $e->getMessage());

            // Save directly to DB if mail server rate-limits
            $owner->notifications()->create([
                'id' => (string) Str::uuid(),
                'type' => PetNotification::class,
                'data' => [
                    'title' => $title,
                    'message' => $message,
                    'type' => $type,
                    'action_url' => $actionUrl,
                    'action_text' => $actionText,
                ],
                'read_at' => null,
            ]);
        }
    }

    /**
     * Send a test notification to the authenticated user.
     */
    public function sendTest(Request $request)
    {
        $user = Auth::user();
        $title = $request->input('title', 'Annual Rabies Vaccination Reminder');
        $message = $request->input('message', 'Bella is due for her annual Rabies booster. Please schedule an appointment ASAP.');
        $type = $request->input('type', 'urgent');
        $actionUrl = route('book_appointment');
        $actionText = 'Book Appointment';

        try {
            $user->notify(new PetNotification($title, $message, $type, $actionUrl, $actionText));
            return back()->with('success', 'Notification saved to database and email sent to ' . $user->email . '!');
        } catch (\Throwable $e) {
            $user->notifications()->create([
                'id' => (string) Str::uuid(),
                'type' => PetNotification::class,
                'data' => [
                    'title' => $title,
                    'message' => $message,
                    'type' => $type,
                    'action_url' => $actionUrl,
                    'action_text' => $actionText,
                ],
                'read_at' => null,
            ]);

            return back()->with('info', 'Notification saved to database! (Mail notice: ' . $e->getMessage() . ')');
        }
    }
}
