<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserAssignmentRequest;
use App\Http\Requests\UpdateUserAssignmentRequest;
use App\Models\UserAssignment;
use App\Models\User;
use App\Models\PpeEquipment;
use App\Models\Audit;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAssignmentController extends Controller
{
    /**
     * Apply middleware for permissions
     */
    public function __construct()
    {
        $this->middleware('permission:show_user_assignments', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_user_assignments', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_user_assignments', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_user_assignments', ['only' => ['destroy', 'massDeleteUserAssignments']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_assignments = UserAssignment::with('user', 'ppeEquipment')->get();

        // Record an audit trail for the read action
        Audit::create([
            'action_type' => 'Read',
            'resource_affected' => 'User Assignment',
            'previous_state' => null,
            'new_state' => json_encode($user_assignments),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        return view('PPE-equipment-management-onboarding.UserAssignment.index', compact('user_assignments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $ppeEquipments = PpeEquipment::all();
        return view('PPE-equipment-management-onboarding.UserAssignment.create', compact('users', 'ppeEquipments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserAssignmentRequest $request)
    {
        $validatedData = $request->validated();

        // Log the Create action
        Log::create([
            'action_performed' => 'Create User Assignment',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the create action
        Audit::create([
            'action_type' => 'Create',
            'resource_affected' => 'User Assignment',
            'previous_state' => null,
            'new_state' => json_encode($validatedData),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        $user_assignments = UserAssignment::create($validatedData);

        if ($user_assignments) {
            return response()->json(['message' => 'User Assignment Created Successfully!'], 200);
        }

        return response()->json(['message' => 'Error Creating User Assignment!'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserAssignment $userAssignment)
    {
        // return view('user_assignments.show', compact('userAssignment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserAssignment $user_assignment)
    {
        //dd($user_assignment);
        $users = User::all();
        $ppeEquipments = PpeEquipment::all();
        return view('PPE-equipment-management-onboarding.UserAssignment.create', compact('user_assignment', 'users', 'ppeEquipments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserAssignmentRequest $request, UserAssignment $user_assignment)
    {
        $validatedData = $request->validated();
        $oldState = $user_assignment->toArray();

        if ($user_assignment->update($validatedData)) {

            // Log the Update action
            Log::create([
                'action_performed' => 'Update User Assignment',
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            // Record an audit trail for the update action
            Audit::create([
                'action_type' => 'Update',
                'resource_affected' => 'User Assignment',
                'previous_state' => json_encode($oldState),
                'new_state' => json_encode($user_assignment->toArray()),
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->roles->pluck('name')->first(),
            ]);

            return response()->json(['message' => 'User Assignment Updated Successfully'], 200);
        }

        return response()->json(['message' => 'Error Updating User Assignment'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserAssignment $user_assignment)
    {
        $oldState = $user_assignment->toArray();

        if ($user_assignment->delete()) {

            // Log the Delete action
            Log::create([
                'action_performed' => 'Delete User Assignment',
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            // Record an audit trail for the delete action
            Audit::create([
                'action_type' => 'Delete',
                'resource_affected' => 'User Assignment',
                'previous_state' => json_encode($oldState),
                'new_state' => null,
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->roles->pluck('name')->first(),
            ]);

            return response()->json(['message' => 'User Assignment Deleted Successfully'], 200);
        }

        return response()->json(['message' => 'User Assignment Not Found'], 404);
    }

    /**
     * Mass delete User Assignments.
     */
    public function massDeleteUserAssignments(Request $request)
    {
        $ids = $request->ids;
        UserAssignment::destroy($ids);

        return response()->json(['message' => 'User Assignments Deleted Successfully']);
    }
}
