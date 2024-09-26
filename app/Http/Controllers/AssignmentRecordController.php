<?php

namespace App\Http\Controllers;

use App\Models\AssignmentRecord;
use App\Models\PpeEquipment;
use App\Models\User;
use App\Http\Requests\StoreAssignmentRecordRequest;
use App\Http\Requests\UpdateAssignmentRecordRequest;
use Illuminate\Http\Request;
use App\Models\Audit;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class AssignmentRecordController extends Controller
{

    /**
    * Apply middleware for permissions
    */
    public function __construct()
    {
        $this->middleware('permission:show_assignmentRecords', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_assignmentRecords', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_assignmentRecords', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_assignmentRecords', ['only' => ['destroy', 'massDeleteAssignmentRecords']]);
    }
    public function index()
    {
        $assignmentRecords = AssignmentRecord::with(['ppeEquipment', 'user'])->get();
        // Log the Read action
        Log::create([
            'action_performed' => 'Read Assignment Record List',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the read action
        Audit::create([
            'action_type' => 'Read',  // Indicating a read action
            'resource_affected' => 'Assignment Record', // Specify the resource being accessed
            'previous_state' => null, // No previous state needed for read-only action
            'new_state' => json_encode($assignmentRecords), // Capture the state of the resources being read
            'user_id' => Auth::id(), // User ID performing the action
            'user_role' => Auth::user()->roles->pluck('name')->first(), // User role
       ]);
        return view('assignment-records.index', compact('assignmentRecords'));
    }

    public function create()
    {
        $ppeEquipments = PpeEquipment::all();
        $users = User::all();
        return view('assignment-records.create', compact('ppeEquipments', 'users'));
    }

    public function store(StoreAssignmentRecordRequest $request)
    {
        $validatedData = $request->validated();
        AssignmentRecord::create($validatedData);

        // Log the Create action
        Log::create([
            'action_performed' => 'Create Assignment Record',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the create action
        Audit::create([
            'action_type' => 'Create',
            'resource_affected' => 'Assignment Record',
            'previous_state' => null, // No previous state for create
            'new_state' => json_encode($validatedData), // Capture the new state of the created assignment
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        return response()->json(['message' => 'Assignment Record added successfully!']);
    }

    public function edit(AssignmentRecord $assignment_record)
    {
        $assignment = $assignment_record;
        $ppeEquipments = PpeEquipment::all();
        $users = User::all();

        return view('assignment-records.create', compact('assignment', 'ppeEquipments', 'users'));
    }

    public function update(UpdateAssignmentRecordRequest $request, AssignmentRecord $assignment_record)
    {
        $data = $request->validated();
        $oldState = $assignment_record->toArray(); // Capture the old state before updating

        $newState = $assignment_record->toArray(); // Capture the new state after updating
        $assignment_record->update($data);

        // Log the Update action
        Log::create([
            'action_performed' => 'Update Assignment Record',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the update action
        Audit::create([
            'action_type' => 'Update',
            'resource_affected' => 'Assignment Record',
            'previous_state' => json_encode($oldState), // Old state before the update
            'new_state' => json_encode($newState), // New state after the update
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        return response()->json(['message' => 'PPE Assignment updated successfully!']);
    }

    public function destroy(AssignmentRecord $assignment_record)
    {
        $oldState = $assignment_record->toArray(); // Capture the old state before deletion
        $assignment_record->delete();

        // Log the Delete action
        Log::create([
            'action_performed' => 'Delete Assignment Record',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the delete action
        Audit::create([
            'action_type' => 'Delete',
            'resource_affected' => 'Assignment Record',
            'previous_state' => json_encode($oldState), // Old state before deletion
            'new_state' => null, // No new state for delete
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        return response()->json(['message' => 'PPE Assignment deleted successfully!']);
    }

    /**
    * Mass delete media items.
    */
    public function massDeleteAssignmentRecords(Request $request)
    {
        $ids = $request->ids;
        AssignmentRecord::destroy($ids);

        return response()->json(['message' => 'PPE Assignment Successfully']);
    }
}