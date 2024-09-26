<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDriverProfileRequest;
use App\Http\Requests\UpdateDriverProfileRequest;
use App\Models\DriverProfile;
use Illuminate\Http\Request;
use App\Models\Audit;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class DriverProfileController extends Controller
{
    /**
    * Apply middleware for permissions
    */
    public function __construct()
    {
        $this->middleware('permission:show_driver_profiles', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_driver_profiles', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_driver_profiles', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_driver_profiles', ['only' => ['destroy', 'massDeleteProfiles']]);
    }

    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $driverProfiles = DriverProfile::all();

        // Record an audit trail for the read action
        Audit::create([
            'action_type' => 'Read',
            'resource_affected' => 'DriverProfile',
            'previous_state' => null,
            'new_state' => json_encode($driverProfiles),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        return view('driver-profiles.index', compact('driverProfiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('driver-profiles.create');
    }

    /**
    * Store a newly created resource in storage.
    */
    public function store(StoreDriverProfileRequest $request)
    {
        $validatedData = $request->validated();

        // Log the Create action
        Log::create([
            'action_performed' => 'Create Driver Profile',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the create action
        Audit::create([
            'action_type' => 'Create',
            'resource_affected' => 'DriverProfile',
            'previous_state' => null,
            'new_state' => json_encode($validatedData),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        $driverProfiles = DriverProfile::create($validatedData);

        if ($driverProfiles) {
            return response()->json(['message' => 'Driver Profile Created Successfully!'], 200);
        }

        return response()->json(['message' => 'Error Occurred While Creating Driver Profile!'], 500);
    }

    /**
    * Display the specified resource.
    */
    public function show(DriverProfile $driverProfile)
    {
        // return view('driver-profiles.show', compact('driverProfile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DriverProfile $driverprofile)
    {
        //dd($driverprofile);
        if ($driverprofile) {
            return view('driver-profiles.create', compact('driverprofile'));
        }
    
        return response()->json(['message' => 'Driver Profile Not Found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDriverProfileRequest $request, DriverProfile $driverprofile)
    {
        $validatedData = $request->validated();
        $oldState = $driverprofile->toArray();

        if ($driverprofile->update($validatedData)) {

            // Log the Update action
            Log::create([
                'action_performed' => 'Update Driver Profile',
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            // Record an audit trail for the update action
            Audit::create([
                'action_type' => 'Update',
                'resource_affected' => 'DriverProfile',
                'previous_state' => json_encode($oldState),
                'new_state' => json_encode($validatedData),
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->roles->pluck('name')->first(),
            ]);

            return response()->json(['message' => 'Driver Profile Updated Successfully'], 200);
        }

        return response()->json(['message' => 'Error Occurred While Updating Driver Profile'], 500);
    }

    /**
    * Remove the specified resource from storage.
    */
    public function destroy(DriverProfile $driverprofile)
    {
        $oldState = $driverprofile->toArray();

        if ($driverprofile) {
            if ($driverprofile->delete()) {

                // Log the Delete action
                Log::create([
                    'action_performed' => 'Delete Driver Profile',
                    'user_id' => Auth::id(),
                    'ip_address' => request()->ip(),
                ]);

                // Record an audit trail for the delete action
                Audit::create([
                    'action_type' => 'Delete',
                    'resource_affected' => 'DriverProfile',
                    'previous_state' => json_encode($oldState),
                    'new_state' => null,
                    'user_id' => Auth::id(),
                    'user_role' => Auth::user()->roles->pluck('name')->first(),
                ]);

                return response()->json(['message' => 'Driver Profile Deleted Successfully'], 200);
            }
        }

        return response()->json(['message' => 'Driver Profile Not Found'], 404);
    }

    /**
    * Mass delete Driver Profile items.
    */
    public function massDeleteProfiles(Request $request)
    {
        $ids = $request->ids;
        DriverProfile::destroy($ids);

        return response()->json(['message' => 'Driver Profiles Deleted Successfully']);
    }
}
