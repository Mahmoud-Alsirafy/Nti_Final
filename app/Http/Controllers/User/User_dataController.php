<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserDataValidationRequest;
use App\Models\Personal_data;
use App\Models\User;
use App\Traits\AttachFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class User_dataController extends Controller
{
    use AttachFiles;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $info = User::where('id', Auth::id())->with('images')->get();
        return view('test.user.data', compact('info'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('test.user.add_personal_data');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddUserDataValidationRequest $request)
    {
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
    public function regenerate()
    {
        $user = Auth::user();
        $user->qr_code = (string) Str::uuid();
        $user->save();

        event(new \App\Events\GenrateQr($user));

        return back()->with('success', 'QR Code regenerated successfully.');
    }
}
