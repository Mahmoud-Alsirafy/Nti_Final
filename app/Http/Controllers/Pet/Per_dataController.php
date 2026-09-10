<?php

namespace App\Http\Controllers\Pet;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddPetValidationRequest;
use App\Models\Adoption;
use App\Models\Pet_info;
use App\Traits\AttachFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Per_dataController extends Controller
{
    use AttachFiles;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pet_datas = Pet_info::where('ownerId', Auth::id())->with('owner', 'images')->get();
        return view('pets.index', compact('pet_datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        try {
            DB::beginTransaction();
            $pet_data = Pet_info::create([
                'ownerId'     => Auth::id(),
                'name'        => $request->name,
                'Personality' => $request->Personality,
                'gender'      => $request->gender,
                'whight'      => $request->whight,
                'type'        => $request->type,
                'status'      => $request->status,
                'categore'    => $request->categore,
                'description' => $request->description,
                'age'         => $request->age,
                'health_info' => $request->health_info,
            ]);
            if ($request->hasFile('image')) {
                $images = $request->file('image');
                if (!is_array($images)) {
                    $images = [$images];
                }

                foreach ($images as $image) {
                    if ($image && $image->isValid()) {
                        $this->uploadFile(
                            $image,
                            $pet_data,
                            'pet'
                        );
                    }
                }
            }

            DB::commit();
            return redirect()->route('Pet.index')->with('success', 'Your personal data has been saved');
        } catch (\Throwable $e) {
            DB::rollback();
            // dd($e);
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pet_datas = Pet_info::with(['images', 'adoptions.adopter'])->findOrFail($id);
        $images = $pet_datas->images;
        return view('pets.show', compact('pet_datas', 'images'));
    }

    /**
     * Store the pet for adoption.
     */
    public function store_for_adoption(Request $request)
    {
        $request->validate([
            'pet_id' => 'required|exists:pet_infos,id',
        ]);

        try {
            DB::beginTransaction();

            $pet = Pet_info::findOrFail($request->pet_id);

            // Ensure the authenticated user owns this pet
            if ($pet->ownerId != Auth::id()) {
                return redirect()->back()->withErrors(['error' => 'You are not authorized to put this pet up for adoption.']);
            }

            // Check if this pet is already listed for adoption
            $existing = Adoption::where('pet_id', $pet->id)->first();
            if ($existing) {
                return redirect()->back()->with('info', 'This pet is already listed for adoption.');
            }

            Adoption::create([
                'pet_id'   => $pet->id,
                'owner_id' => Auth::id(),
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Pet has been successfully listed for adoption!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to list pet for adoption: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}