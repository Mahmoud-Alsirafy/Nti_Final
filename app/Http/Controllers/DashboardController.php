<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\Pet_info;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Display the Doctor's Dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // If non-admin (regular user) accesses dashboard, redirect to their pets
        if ($user->type !== 'admin') {
            return redirect()->route('Pet.index');
        }

        // Live clinic statistics
        $totalPets = Pet_info::count();
        $totalOwners = User::where('type', 'user')->count();
        $healthyPets = Pet_info::where('status', 'health')->count();
        $totalAdoptions = Adoption::count();

        // Recent Patients (pets) with owner and images
        $recentPets = Pet_info::with(['owner', 'images'])
            ->latest()
            ->take(6)
            ->get();

        // Doctor's clinic details
        $clinic = $user->personalData;

        return view('dashboard', compact(
            'totalPets',
            'totalOwners',
            'healthyPets',
            'totalAdoptions',
            'recentPets',
            'clinic'
        ));
    }

    /**
     * Search for pet(s) by owner email and password.
     */
    public function searchPet(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $owner = User::where('email', $request->email)->first();

        if (!$owner) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No registered pet owner found with this email address.',
                ], 404);
            }

            return back()->withInput()->withErrors([
                'search_error' => 'No registered pet owner found with this email address.',
            ]);
        }

        if (!Hash::check($request->password, $owner->password)) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Incorrect password for this pet owner. Verification failed.',
                ], 401);
            }

            return back()->withInput()->withErrors([
                'search_error' => 'Incorrect password for this pet owner. Verification failed.',
            ]);
        }

        // Fetch owner's pets with images and adoptions
        $pets = Pet_info::where('ownerId', $owner->id)
            ->with(['images', 'adoptions'])
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Owner verified successfully.',
                'owner'   => [
                    'id'         => $owner->id,
                    'name'       => $owner->name,
                    'email'      => $owner->email,
                    'phone'      => $owner->phone,
                    'qr_code'    => $owner->qr_code,
                    'pets_count' => $pets->count(),
                ],
                'pets'    => $pets->map(function ($p) {
                    $imgUrl = null;
                    if ($p->images && $p->images->isNotEmpty()) {
                        $imgUrl = asset('storage/uploads/attachments/pet/' . $p->id . '/' . $p->images->first()->filename);
                    }
                    return [
                        'id'          => $p->id,
                        'name'        => $p->name,
                        'type'        => $p->type,
                        'categore'    => $p->categore,
                        'gender'      => $p->gender,
                        'age'         => $p->age,
                        'whight'      => $p->whight,
                        'status'      => $p->status,
                        'Personality' => $p->Personality,
                        'description' => $p->description,
                        'health_info' => $p->health_info,
                        'image_url'   => $imgUrl,
                        'show_url'    => route('Pet.show', $p->id),
                    ];
                }),
            ]);
        }

        return redirect()->route('dashboard')->with([
            'search_success' => true,
            'searched_owner' => $owner,
            'searched_pets'  => $pets,
            'searched_email' => $request->email,
        ]);
    }

    /**
     * Search for a pet owner and their pets by QR Code / Token.
     */
    public function searchUserByQr(Request $request, $token = null)
    {
        $qrInput = trim($token ?? $request->input('qr_code') ?? $request->input('token') ?? '');

        // If scanned text is a full URL, extract the token from the end
        if (str_contains($qrInput, '/')) {
            $parts = explode('/', rtrim($qrInput, '/'));
            $qrInput = end($parts);
        }

        if (empty($qrInput)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please provide or scan a valid QR Code.',
                ], 422);
            }

            return back()->withInput()->withErrors([
                'search_error' => 'Please provide or scan a valid QR Code.',
            ]);
        }

        $owner = User::where('qr_code', $qrInput)
            ->orWhere('id', $qrInput)
            ->first();

        if (!$owner) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "No registered pet owner found matching QR Code: '{$qrInput}'.",
                ], 404);
            }

            return back()->withInput()->withErrors([
                'search_error' => "No registered pet owner found matching QR Code: '{$qrInput}'.",
            ]);
        }

        $pets = Pet_info::where('ownerId', $owner->id)
            ->with(['images', 'adoptions', 'medicalRecords'])
            ->get();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Owner '{$owner->name}' verified via QR Code.",
                'owner'   => [
                    'id'         => $owner->id,
                    'name'       => $owner->name,
                    'email'      => $owner->email,
                    'phone'      => $owner->phone,
                    'qr_code'    => $owner->qr_code,
                    'type'       => $owner->type,
                    'pets_count' => $pets->count(),
                ],
                'pets'    => $pets->map(function ($p) {
                    $imgUrl = null;
                    if ($p->images && $p->images->isNotEmpty()) {
                        $imgUrl = asset('storage/uploads/attachments/pet/' . $p->id . '/' . $p->images->first()->filename);
                    }
                    return [
                        'id'          => $p->id,
                        'name'        => $p->name,
                        'type'        => $p->type,
                        'categore'    => $p->categore,
                        'gender'      => $p->gender,
                        'age'         => $p->age,
                        'whight'      => $p->whight,
                        'status'      => $p->status,
                        'Personality' => $p->Personality,
                        'description' => $p->description,
                        'health_info' => $p->health_info,
                        'image_url'   => $imgUrl,
                        'show_url'    => route('Pet.show', $p->id),
                        'medical_url' => route('medical_history', $p->id),
                    ];
                }),
            ]);
        }

        return redirect()->route('dashboard')->with([
            'search_success' => true,
            'searched_owner' => $owner,
            'searched_pets'  => $pets,
            'searched_qr'    => $qrInput,
        ]);
    }
}
