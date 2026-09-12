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
        $pet_data = Pet_info::with('images')->findOrFail($id);

        if ($pet_data->ownerId != Auth::id()) {
            return redirect()->route('Pet.index')->withErrors(['error' => 'You are not authorized to edit this pet.']);
        }

        return view('pets.edit', compact('pet_data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pet_data = Pet_info::findOrFail($id);

        if ($pet_data->ownerId != Auth::id()) {
            return redirect()->route('Pet.index')->withErrors(['error' => 'You are not authorized to update this pet.']);
        }

        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'Personality' => ['required', 'string', 'max:500'],
            'gender'      => ['required', 'in:Male,Female'],
            'whight'      => ['required', 'numeric', 'min:0'],
            'type'        => ['required', 'string', 'max:255'],
            'status'      => ['required', 'in:health,sick,unknown'],
            'categore'    => ['required', 'in:Dogs,Cats,birds,other'],
            'description' => ['required', 'string'],
            'health_info' => ['required', 'string'],
            'age'         => ['required', 'integer', 'min:0', 'max:255'],
            'image'       => ['nullable'],
            'image.*'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ]);

        try {
            DB::beginTransaction();

            $pet_data->update([
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

            // Handle deleting selected existing images
            if ($request->filled('delete_images') && is_array($request->delete_images)) {
                foreach ($request->delete_images as $imageId) {
                    $img = \App\Models\Images::where('id', $imageId)
                        ->where('imageable_id', $pet_data->id)
                        ->where('imageable_type', Pet_info::class)
                        ->first();

                    if ($img) {
                        $filePath = 'attachments/pet/' . $pet_data->id . '/' . $img->filename;
                        \Illuminate\Support\Facades\Storage::disk('uploads')->delete($filePath);
                        $img->delete();
                    }
                }
            }

            // Handle uploading new images
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

            return redirect()->route('Pet.show', $pet_data->id)->with('success', 'Pet data updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update pet: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pet_data = Pet_info::findOrFail($id);

        if ($pet_data->ownerId != Auth::id()) {
            return redirect()->route('Pet.index')->withErrors(['error' => 'You are not authorized to delete this pet.']);
        }

        try {
            DB::beginTransaction();
            $this->deleteFile($pet_data, 'pet');
            $pet_data->delete();
            DB::commit();

            return redirect()->route('Pet.index')->with('success', 'Pet deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to delete pet: ' . $e->getMessage()]);
        }
    }
}
