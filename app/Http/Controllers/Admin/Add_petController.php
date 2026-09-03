<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddPetValidationRequest;
use App\Traits\AttachFiles;
use App\Models\Pet_info;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Add_petController extends Controller
{
    use AttachFiles;

    public function index()
    {
        $pet_data = Pet_info::where('ownerId', Auth::id())->with('owner', 'images')->get();

        return view('test.admin.show_pet_data', compact('pet_data'));
    }
    public function create()
    {
        return view('test.admin.add_new_pet');
    }

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

            $pet_data = Pet_info::updateOrCreate(
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
}
