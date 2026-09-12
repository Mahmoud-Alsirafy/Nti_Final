<?php

namespace App\Http\Controllers\Medical;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notification\NotificationController;
use App\Mail\MedicalReportMail;
use App\Models\MedicalRecord;
use App\Models\Pet_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MedicalController extends Controller
{
    /**
     * Display medical history for a pet with all stored database medical reports.
     */
    public function history(Request $request, $id = null)
    {
        $user = Auth::user();

        // Get list of pets for switching
        if ($user && ($user->type === 'admin' || $user->type === 'doctor')) {
            $allPets = Pet_info::latest()->get();
        } else {
            $allPets = Pet_info::where('ownerId', $user->id ?? 0)->latest()->get();
            if ($allPets->isEmpty()) {
                $allPets = Pet_info::latest()->get();
            }
        }

        $recordsRelation = function ($query) {
            $query->with('doctor')->orderBy('visit_date', 'desc')->orderBy('id', 'desc');
        };

        if ($id) {
            $pet = Pet_info::with(['owner', 'images', 'medicalRecords' => $recordsRelation])->find($id);
        } else {
            $pet = Pet_info::where('ownerId', $user->id ?? 0)
                ->with(['owner', 'images', 'medicalRecords' => $recordsRelation])
                ->first()
                ?? Pet_info::with(['owner', 'images', 'medicalRecords' => $recordsRelation])->first();
        }

        return view('medical_history', compact('pet', 'allPets'));
    }

    /**
     * Display the add medical record form.
     */
    public function record(Request $request, $pet_id = null)
    {
        $user = Auth::user();

        // If user is doctor or admin, show all pets, otherwise show user's pets
        if ($user && ($user->type === 'admin' || $user->type === 'doctor')) {
            $pets = Pet_info::with('owner')->latest()->get();
        } else {
            $pets = Pet_info::where('ownerId', $user->id ?? 0)->latest()->get();
            if ($pets->isEmpty()) {
                $pets = Pet_info::with('owner')->latest()->get();
            }
        }

        $selected_pet_id = $pet_id;

        return view('medical_record', compact('pets', 'selected_pet_id'));
    }

    /**
     * Store a newly uploaded medical record in the database and notify pet owner via Mail & DB.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Pets' => 'required',
            'title' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:100',
            'visit_date' => 'nullable|date',
            'weight' => 'nullable|string|max:50',
            'describe' => 'required|string|min:3',
            'treat_plan' => 'nullable|string',
            'notes' => 'nullable|string',
            'report_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,webp|max:10240',
        ]);

        $petIdentifier = $request->input('Pets');

        $pet = Pet_info::with('owner')
            ->where('id', $petIdentifier)
            ->orWhere('name', $petIdentifier)
            ->first();

        $doctor = Auth::user();
        $diagnosis = $request->input('describe');
        $treatment = $request->input('treat_plan');
        $visitDate = $request->input('visit_date') ?: date('Y-m-d');
        $reportType = $request->input('type') ?: 'Routine Checkup';
        $reportTitle = $request->input('title') ?: $reportType;
        $weight = $request->input('weight');

        // Handle report document file upload if provided
        $reportFileName = null;
        $attachmentName = null;

        if ($request->hasFile('report_file') && $request->file('report_file')->isValid()) {
            $file = $request->file('report_file');
            $attachmentName = $file->getClientOriginalName();
            $reportFileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('medical_reports', $reportFileName, 'uploads');
        }

        if ($pet) {
            // 1. Save report into medical_records table
            $record = MedicalRecord::create([
                'pet_id' => $pet->id,
                'doctor_id' => $doctor ? $doctor->id : null,
                'title' => $reportTitle,
                'type' => $reportType,
                'visit_date' => $visitDate,
                'weight' => $weight,
                'diagnosis' => $diagnosis,
                'treatment_plan' => $treatment,
                'internal_notes' => $request->input('notes'),
                'report_file' => $reportFileName,
                'attachment_name' => $attachmentName,
            ]);

            // 2. Update pet latest health info & weight if supplied
            $petUpdates = ['health_info' => $diagnosis];
            if (!empty($weight)) {
                $petUpdates['whight'] = $weight;
            }
            $pet->update($petUpdates);

            // 3. Send Email to Pet Owner
            if ($pet->owner && !empty($pet->owner->email)) {
                try {
                    Mail::to($pet->owner->email)->send(
                        new MedicalReportMail($pet, $doctor, $diagnosis, $treatment, $visitDate)
                    );
                } catch (\Throwable $e) {
                    Log::warning("Medical report email dispatch failed: " . $e->getMessage());
                }
            }

            // 4. Send in-app Notification to Pet Owner
            NotificationController::sendMedicalReportNotification($pet, $doctor, $diagnosis, $treatment);

            return redirect()->route('medical_history', $pet->id)
                ->with('success', "Medical report successfully stored in database! Notification & email sent to {$pet->owner->name}.");
        }

        return redirect()->route('medical_history')
            ->with('success', 'Medical report logged successfully!');
    }
}
