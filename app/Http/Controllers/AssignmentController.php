<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Requests\UpdateAssignmentRequest;
use App\Models\Assignment;
use App\Models\DriverProfile;
use App\Models\Audit;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    /**
    * Apply middleware for permissions
    */
    public function __construct()
    {
        $this->middleware('permission:show_assignments', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_assignments', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_assignments', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_assignments', ['only' => ['destroy', 'massDeleteAssignments']]);
    }

    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $assignments = Assignment::with('driverProfile')->get();

        // Record an audit trail for the read action
        Audit::create([
            'action_type' => 'Read',
            'resource_affected' => 'Assignment',
            'previous_state' => null,
            'new_state' => json_encode($assignments),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        return view('assignments.index', compact('assignments'));
    }

    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        $driverProfiles = DriverProfile::all();
        return view('assignments.create', compact('driverProfiles'));
    }

    /**
    * Store a newly created resource in storage.
    */
    public function store(StoreAssignmentRequest $request)
    {
        $validatedData = $request->validated();

        // Log the Create action
        Log::create([
            'action_performed' => 'Create Assignment',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the create action
        Audit::create([
            'action_type' => 'Create',
            'resource_affected' => 'Assignment',
            'previous_state' => null,
            'new_state' => json_encode($validatedData),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        $assignment = Assignment::create($validatedData);

        if ($assignment) {
            return response()->json(['message' => 'Assignment Created Successfully!'], 200);
        }

        return response()->json(['message' => 'Error Occurred While Creating Assignment!'], 500);
    }

    /**
    * Display the specified resource.
    */
    public function show(Assignment $assignment)
    {
        // return view('assignments.show', compact('assignment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assignment $assignment)
    {
        $driverProfiles = DriverProfile::all();

        if ($assignment) {
            return view('assignments.create', compact('assignment', 'driverProfiles'));
        }

        return response()->json(['message' => 'Assignment Not Found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssignmentRequest $request, Assignment $assignment)
    {
        $validatedData = $request->validated();
        $oldState = $assignment->toArray();

        if ($assignment->update($validatedData)) {

            // Log the Update action
            Log::create([
                'action_performed' => 'Update Assignment',
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            // Record an audit trail for the update action
            Audit::create([
                'action_type' => 'Update',
                'resource_affected' => 'Assignment',
                'previous_state' => json_encode($oldState),
                'new_state' => json_encode($validatedData),
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->roles->pluck('name')->first(),
            ]);

            return response()->json(['message' => 'Assignment Updated Successfully'], 200);
        }

        return response()->json(['message' => 'Error Occurred While Updating Assignment'], 500);
    }

    /**
    * Remove the specified resource from storage.
    */
    public function destroy(Assignment $assignment)
    {
        $oldState = $assignment->toArray();

        if ($assignment->delete()) {

            // Log the Delete action
            Log::create([
                'action_performed' => 'Delete Assignment',
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            // Record an audit trail for the delete action
            Audit::create([
                'action_type' => 'Delete',
                'resource_affected' => 'Assignment',
                'previous_state' => json_encode($oldState),
                'new_state' => null,
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->roles->pluck('name')->first(),
            ]);

            return response()->json(['message' => 'Assignment Deleted Successfully'], 200);
        }

        return response()->json(['message' => 'Assignment Not Found'], 404);
    }

    /**
    * Mass delete Assignments.
    */
    public function massDeleteAssignments(Request $request)
    {
        $ids = $request->ids;
        Assignment::destroy($ids);

        return response()->json(['message' => 'Assignments Deleted Successfully']);
    }
}
