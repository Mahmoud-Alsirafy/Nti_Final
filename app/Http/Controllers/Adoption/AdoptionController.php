<?php

namespace App\Http\Controllers\Adoption;

use App\Http\Controllers\Controller;
use App\Models\Adoption;
use Illuminate\Http\Request;

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
}
