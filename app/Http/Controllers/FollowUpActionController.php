<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFollowUpActionRequest;
use App\Http\Requests\UpdateFollowUpActionRequest;
use App\Models\FollowUpAction;
use App\Models\IncidentView;
use App\Models\User;
use App\Models\Audit;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowUpActionController extends Controller
{
    /**
    * Apply middleware for permissions
    */
    public function __construct()
    {
        $this->middleware('permission:show_follow_up_actions', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_follow_up_actions', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_follow_up_actions', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_follow_up_actions', ['only' => ['destroy', 'massDeleteFollowUpActions']]);
    }

    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $followUpActions = FollowUpAction::with('incidentView', 'assignedUser')->get();

        // Record an audit trail for the read action
        Audit::create([
            'action_type' => 'Read',
            'resource_affected' => 'FollowUpAction',
            'previous_state' => null,
            'new_state' => json_encode($followUpActions),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        return view('Incident-Reporting-Management.follow-up-actions.index', compact('followUpActions'));
    }

    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        $incidentViews = IncidentView::all();
        $users = User::all();
        return view('Incident-Reporting-Management.follow-up-actions.create', compact('incidentViews', 'users'));
    }

    /**
    * Store a newly created resource in storage.
    */
    public function store(StoreFollowUpActionRequest $request)
    {
        $validatedData = $request->validated();

        // Log the Create action
        Log::create([
            'action_performed' => 'Create Follow-Up Action',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the create action
        Audit::create([
            'action_type' => 'Create',
            'resource_affected' => 'FollowUpAction',
            'previous_state' => null,
            'new_state' => json_encode($validatedData),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        $followUpAction = FollowUpAction::create($validatedData);

        if ($followUpAction) {
            return response()->json(['message' => 'Follow-Up Action Created Successfully!'], 200);
        }

        return response()->json(['message' => 'Error Occurred While Creating Follow-Up Action!'], 500);
    }

    /**
    * Display the specified resource.
    */
    public function show(FollowUpAction $followUpAction)
    {
        // return view('followUpActions.show', compact('followUpAction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FollowUpAction $followUpAction)
    {
        //dd($followUpAction);
        $incidentViews = IncidentView::all();
        $users = User::all();

        if ($followUpAction) {
            return view('Incident-Reporting-Management.follow-up-actions.create', compact('followUpAction', 'incidentViews', 'users'));
        }

        return response()->json(['message' => 'Follow-Up Action Not Found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFollowUpActionRequest $request, FollowUpAction $followUpAction)
    {
        $validatedData = $request->validated();
        $oldState = $followUpAction->toArray();

        if ($followUpAction->update($validatedData)) {

            // Log the Update action
            Log::create([
                'action_performed' => 'Update Follow-Up Action',
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            // Record an audit trail for the update action
            Audit::create([
                'action_type' => 'Update',
                'resource_affected' => 'FollowUpAction',
                'previous_state' => json_encode($oldState),
                'new_state' => json_encode($validatedData),
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->roles->pluck('name')->first(),
            ]);

            return response()->json(['message' => 'Follow-Up Action Updated Successfully'], 200);
        }

        return response()->json(['message' => 'Error Occurred While Updating Follow-Up Action'], 500);
    }

    /**
    * Remove the specified resource from storage.
    */
    public function destroy(FollowUpAction $followUpAction)
    {
        $oldState = $followUpAction->toArray();

        if ($followUpAction->delete()) {

            // Log the Delete action
            Log::create([
                'action_performed' => 'Delete Follow-Up Action',
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            // Record an audit trail for the delete action
            Audit::create([
                'action_type' => 'Delete',
                'resource_affected' => 'FollowUpAction',
                'previous_state' => json_encode($oldState),
                'new_state' => null,
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->roles->pluck('name')->first(),
            ]);

            return response()->json(['message' => 'Follow-Up Action Deleted Successfully'], 200);
        }

        return response()->json(['message' => 'Follow-Up Action Not Found'], 404);
    }

    /**
    * Mass delete Follow-Up Actions.
    */
    public function massDeleteFollowUpActions(Request $request)
    {
        $ids = $request->ids;
        FollowUpAction::destroy($ids);

        return response()->json(['message' => 'Follow-Up Actions Deleted Successfully']);
    }
}
