<?php

namespace App\Http\Controllers\Admin;

use App\Events\GenrateQr;
use App\Http\Controllers\Controller;
use App\Http\Requests\PersonalDataRequest;
use App\Models\Personal_data;
use App\Traits\AttachFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PersonalDataController extends Controller
{
    use AttachFiles;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Auth::id();
        $info = Personal_data::where('userId', Auth::id())->with('info', 'images')->get();
        return view('test.admin.showPersonalData', compact('info'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('test.admin.add_personal_data');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PersonalDataRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = array_filter([
                'clinicName'    => $request->clinicName,
                'clinicAddress' => $request->clinicAddress,
                'clinicNumber'  => $request->clinicNumber,
            ], fn($value) => !is_null($value));

            $personalData = Personal_data::updateOrCreate(
                ['userId' => Auth::id()],
                $data
            );
            if ($request->hasFile('image')) {
                if ($personalData->images()->exists()) {
                    $this->deleteFile(
                        $personalData->id,
                        'personal'
                    );
                }

                $this->uploadFile(
                    $request->file('image'),
                    $personalData,
                    'personal'
                );
            }
            DB::commit();

            return redirect()->route('Profile.index')->with('success', 'Your personal data has been saved');
        } catch (\Throwable $e) {
            DB::rollback();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function regenerate()
    {
        $user = Auth::user();
        $user->qr_code = (string) Str::uuid();
        $user->save();

        event(new GenrateQr($user));

        return back()->with('success', 'QR Code regenerated successfully.');
    }
}