<?php

namespace App\Http\Controllers\Adoption;

use App\Http\Controllers\Controller;
use App\Models\Adoption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdoptionController extends Controller
{
    public function index()
    {
        $adoptions = Adoption::with(['pet.images', 'owner'])->latest()->get();
        return view('adoption.index', compact('adoptions'));
    }

    public function show($id)
    {
        $adoption = Adoption::with(['pet.images', 'owner', 'adopter'])->findOrFail($id);
        return view('adoption.show', compact('adoption'));
    }

    public function request($id)
    {
        $adoption = Adoption::with(['pet.images', 'owner'])->findOrFail($id);
        return view('adoption.request', compact('adoption'));
    }

    public function new_adoption(Request $request, $id = null)
    {
        $adoptionId = $id ?? $request->id;

        $validatedData = $request->validate([
            'why' => 'required|string|min:5',
        ]);

        $adoption = Adoption::findOrFail($adoptionId);

        if ($adoption->owner_id == Auth::id()) {
            return redirect()->back()->withErrors(['error' => 'You cannot apply to adopt your own pet.']);
        }

        if ($adoption->adopter_id && $adoption->status === 'accepted') {
            return redirect()->back()->withErrors(['error' => 'This pet has already been adopted.']);
        }

        $adoption->update([
            'adopter_id' => Auth::id(),
            'status'     => 'pending',
            'why'        => $validatedData['why'],
        ]);

        // Notify Pet Owner via Database & Email
        \App\Http\Controllers\Notification\NotificationController::sendAdoptionRequestNotification($adoption, Auth::user());

        return redirect()->route('adoptions.show', $adoption->id)
            ->with('success', 'Your adoption application has been submitted successfully! The owner will review your request.');
    }

    /**
     * Accept adoption application and transfer pet to new owner.
     */
    public function accept($id)
    {
        $adoption = Adoption::with(['pet', 'adopter', 'owner'])->findOrFail($id);

        if (Auth::id() != $adoption->owner_id && (Auth::user()->type ?? '') !== 'admin') {
            return redirect()->back()->withErrors(['error' => 'Only the pet owner can accept adoption requests.']);
        }

        if (!$adoption->adopter_id) {
            return redirect()->back()->withErrors(['error' => 'No applicant has applied yet.']);
        }

        $adoption->update([
            'status' => 'accepted',
        ]);

        // Transfer pet ownership to new adopter
        if ($adoption->pet) {
            $adoption->pet->update([
                'ownerId' => $adoption->adopter_id,
            ]);
        }

        // Notify applicant of acceptance
        if ($adoption->adopter) {
            \App\Http\Controllers\Notification\NotificationController::sendAdoptionDecisionNotification($adoption, 'accepted');
        }

        return redirect()->route('adoptions.show', $adoption->id)
            ->with('success', "Adoption approved! {$adoption->pet->name} has been transferred to {$adoption->adopter->name}.");
    }

    /**
     * Reject adoption application and re-open pet listing.
     */
    public function reject($id)
    {
        $adoption = Adoption::with(['pet', 'adopter', 'owner'])->findOrFail($id);

        if (Auth::id() != $adoption->owner_id && (Auth::user()->type ?? '') !== 'admin') {
            return redirect()->back()->withErrors(['error' => 'Only the pet owner can reject adoption requests.']);
        }

        $adopter = $adoption->adopter;

        $adoption->update([
            'status' => 'rejected',
            'adopter_id' => null, // re-open so other users can apply
        ]);

        // Notify applicant of rejection
        if ($adopter) {
            \App\Http\Controllers\Notification\NotificationController::sendAdoptionDecisionNotification($adoption, 'rejected', $adopter);
        }

        return redirect()->route('adoptions.show', $adoption->id)
            ->with('success', 'Adoption request was rejected. The listing is now available for other applicants.');
    }

    public function store_for_adoption(Request $request)
    {
        $validatedData = $request->validate([
            'pet_id' => 'required|exists:pet_infos,id',
            'owner_id' => 'required|exists:users,id',
        ]);
        DB::beginTransaction();
        try {
            $adoption = Adoption::create([
                "pet_id" => $request->pet_id,
                "owner_id" => $request->owner_id,
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Pet successfully submitted for adoption!');
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Failed to store adoption: ' . $e->getMessage()]);
        }
    }

    public function adoption_status(int $owner_id)
    {
        //??remove the $owner_id and use this : return $adoptions = Adoption::where('owner_id', Auth::user()->id())->with('pet', 'owner')->get();
        $adoptions = Adoption::where('owner_id', $owner_id)->where('status', 'pending')->with('pet', 'owner')->get();
        if ($adoptions->count() > 0) {
            return $adoptions;
        } else {
            return "no adoption";
        }
    }
}