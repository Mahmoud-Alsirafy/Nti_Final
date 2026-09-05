<?php

namespace App\Http\Controllers\Adoption;

use App\Http\Controllers\Controller;
use App\Models\Adoption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdoptionController extends Controller
{
    public function index()
    {
        return $adoptions = Adoption::with('pet', 'owner')->get();
        // return view('adoptions.index', compact('adoptions'));
    }

    public function new_adoption(Request $request)
    {
        // return $request;
        $validatedData = $request->validate([
            'id' => 'required|exists:adoptions,id',
            'adopter_id' => 'required|exists:users,id',
            'why' => 'required',
        ]);
        $adoption = Adoption::findOrFail($validatedData['id']);
        $adoption->update(
            [
                'adopter_id' => $validatedData['adopter_id'],
                'status' => 'pending',
                'why' => $validatedData['why'],
            ]
        );
        return $adoption;
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
            // return redirect()->route('Profile.index')->with('success', 'Your personal data has been saved');
            return "store done succesfully";
        } catch (\Throwable $e) {
            DB::rollback();
            //  return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            return "false";
        }
        return $adoption;
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
