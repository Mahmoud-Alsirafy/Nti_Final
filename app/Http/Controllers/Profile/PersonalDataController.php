<?php

namespace App\Http\Controllers\Profile;

use App\Events\GenrateQr;
use App\Http\Controllers\Controller;
use App\Models\Personal_data;
use App\Models\User;
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
        $info = User::where('id', Auth::id())->with('personalData', 'images')->first();
        return view('settings.account', compact('info'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return 'ok';
        return view('test.admin.add_personal_data');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        if (Auth::user()->type === 'admin') {
            try {

                DB::beginTransaction();

                $user = User::findOrFail(Auth::id());

                // 1. Update User info if present
                $userData = array_filter([
                    'name'  => $request->name,
                    'phone' => $request->phone,
                ], fn($value) => !is_null($value));

                if (!empty($userData)) {
                    $user->update($userData);
                }

                $clinicData = array_filter([
                    'clinicName'    => $request->clinicName,
                    'clinicAddress' => $request->clinicAddress,
                    'clinicNumber'  => $request->clinicNumber,
                ], fn($value) => !is_null($value));

                if (!empty($clinicData)) {
                    $personalData = Personal_data::updateOrCreate(
                        ['userId' => Auth::id()],
                        $clinicData
                    );
                } else {
                    $personalData = Personal_data::firstOrCreate(['userId' => Auth::id()]);
                }

                if ($request->hasFile('image')) {
                    if ($request->filled('clinicName') || $request->filled('clinicAddress') || $request->filled('clinicNumber')) {
                        if ($personalData->images()->exists()) {
                            $this->deleteFile($personalData->id, 'personal');
                        }
                        $this->uploadFile($request->file('image'), $personalData, 'personal');
                    } else {
                        if ($user->images()->exists()) {
                            $this->deleteFile($user->id, 'user');
                        }
                        $this->uploadFile($request->file('image'), $user, 'user');
                    }
                }

                DB::commit();

                return redirect()->route('Profile.index')->with('success', 'Your personal data has been saved successfully');
            } catch (\Throwable $e) {
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        } else {
            try {
                DB::beginTransaction();
                $data = array_filter([
                    'name'    => $request->name,
                    'phone' => $request->phone,
                ], fn($value) => !is_null($value));

                $user_data = user::updateOrCreate(
                    ['id' => Auth::id()],
                    $data
                );
                if ($request->hasFile('image')) {
                    if ($user_data->images()->exists()) {
                        $this->deleteFile(
                            $user_data->id,
                            'user'
                        );
                    }

                    $this->uploadFile(
                        $request->file('image'),
                        $user_data,
                        'user'
                    );
                }
                DB::commit();

                return redirect()->route('Profile.index')->with('success', 'Your personal data has been saved');
            } catch (\Throwable $e) {
                DB::rollback();

                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
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