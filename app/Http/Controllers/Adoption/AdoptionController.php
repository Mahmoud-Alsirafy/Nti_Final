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
}
