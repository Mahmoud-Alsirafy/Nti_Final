<?php

namespace App\Http\Controllers\Pet;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddPetValidationRequest;
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
        $pet_data = Pet_info::where('ownerId', Auth::id())->with('owner', 'images')->get();

        return view('test.pet.show_pet_data', compact('pet_data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('test.pet.add_new_pet');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddPetValidationRequest $request)
    {

        try {
            DB::beginTransaction();


            $data = array_filter([
                'name'        => $request->name,
                'Personality' => $request->Personality,
                'gender'      => $request->gender,
                'whight'      => $request->whight,
                'type'        => $request->type,
                'status'      => $request->status,
                'categore'    => $request->categore,
                'description' => $request->description,
                'age'         => $request->age,
            ], fn($value) => !is_null($value));

            $pet_data = pet_info::updateOrCreate(
                ['ownerId' => Auth::id()],
                $data
            );
            if ($request->hasFile('image')) {
                $this->deleteFile(
                    $pet_data->id,
                    'pet'
                );
                foreach ($request->file('image') as $image) {
                    $this->uploadFile(
                        $image,
                        $pet_data,
                        'pet'
                    );
                }
            }

            DB::commit();
            return redirect()->route('Pet.index')->with('success', 'Your personal data has been saved');
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
