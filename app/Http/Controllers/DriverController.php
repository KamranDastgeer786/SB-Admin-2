<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Models\Audit;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{

    /**
    * Apply middleware for permissions
    */
    public function __construct()
    {
        $this->middleware('permission:show_drivers', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_drivers', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_drivers', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_drivers', ['only' => ['destroy', 'massDeleteDrivers']]);
    }
    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $drivers = Driver::all();
        // Record an audit trail for the read action
        Audit::create([
            'action_type' => 'Read',  // Indicating a read action
            'resource_affected' => 'Driver', // Specify the resource being accessed
            'previous_state' => null, // No previous state needed for read-only action
            'new_state' => json_encode( $drivers), // Capture the state of the resources being read
            'user_id' => Auth::id(), // User ID performing the action
            'user_role' => Auth::user()->roles->pluck('name')->first(), // User role
       ]);
        return view('driver-information.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('driver-information.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDriverRequest $request)
    {
        $validatedData = $request->validated();
        // Log the Create action
        Log::create([
            'action_performed' => 'Create Driver',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the create action
        Audit::create([
            'action_type' => 'Create',
            'resource_affected' => 'Driver',
            'previous_state' => null, // No previous state for create
            'new_state' => json_encode($validatedData), // Capture the new state of the created assignment
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        $driver = Driver::create($validatedData);

        if ($driver) {
            return response()->json(['message' => 'Driver Created Successfully!'], 200);
        }

        return response()->json(['message' => 'Some Error Occurred While Creating Driver!'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        // return view('drivers.show', compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        // dd($driver);
        if ($driver) {
            return view('driver-information.create', compact('driver'));
        }

        return response()->json(['message' => 'Driver Not Found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Driver $driver)
    public function update(UpdateDriverRequest $request, Driver $driver)
    {
        // dd($request->all());
        $validatedData = $request->validated();

        // dd($validatedData );
        $oldState = $driver->toArray(); // Capture the old state before updating

        $newState = $driver->toArray();

        if ($driver->update($validatedData)) {

            // Log the Update action
            Log::create([
            'action_performed' => 'Update Driver',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
           ]);

           // Record an audit trail for the update action
           Audit::create([
            'action_type' => 'Update',
            'resource_affected' => 'Driver',
            'previous_state' => json_encode($oldState), // Old state before the update
            'new_state' => json_encode($newState), // New state after the update
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
           ]);
           return response()->json(['message' => 'Driver Updated Successfully'], 200);
        }

        return response()->json(['message' => 'Some Error Occurred While Updating Driver'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        $oldState = $driver->toArray();
        if ($driver) {
            if ($driver->delete()) {

                // Log the Delete action
                Log::create([
                   'action_performed' => 'Delete Driver',
                    'user_id' => Auth::id(),
                    'ip_address' => request()->ip(),
                ]);

                // Record an audit trail for the delete action
                Audit::create([
                  'action_type' => 'Delete',
                   'resource_affected' => 'Driver',
                  'previous_state' => json_encode($oldState), // Old state before deletion
                  'new_state' => null, // No new state for delete
                  'user_id' => Auth::id(),
                   'user_role' => Auth::user()->roles->pluck('name')->first(),
                ]);
                return response()->json(['message' => 'Driver Deleted Successfully'], 200);
            }
        }
        return response()->json(['message' => 'Driver Not Found'], 404);
    }

    /**
     * Update the active status of a driver.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateActiveStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:drivers,id',
            'activeStatus' => 'required|boolean',
        ]);

        $driver = Driver::find($request->input('id'));

        if ($driver) {
            $driver->active = $request->input('activeStatus');
            $driver->save();

            return response()->json(['message' => 'Driver status updated successfully.'], 200);
        }

        return response()->json(['message' => 'Driver not found.'], 404);
    }

    /**
    * Mass delete Drivers items.
    */
    public function massDeleteDrivers(Request $request)
    {
        $ids = $request->ids;
        Driver::destroy($ids);

        return response()->json(['message' => 'Drivers Deleted Successfully']);
    }
}