<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Log;
use App\Models\User;
use App\Models\Audit;
use App\Models\IncidentView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreIncidentViewRequest;
use App\Http\Requests\UpdateIncidentViewRequest;

class IncidentViewController extends Controller
{
    /**
     * Apply middleware for permissions
     */
    public function __construct()
    {
        $this->middleware('permission:show_incident_views', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_incident_views', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_incident_views', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_incident_views', ['only' => ['destroy', 'massDeleteIncidentViews']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incidentViews = IncidentView::all(); // Fetch all incident views for listing
        
        // Record an audit trail for the read action
        Audit::create([
            'action_type' => 'Read',
            'resource_affected' => 'IncidentView',
            'previous_state' => null,
            'new_state' => json_encode($incidentViews),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        return view('Incident-Reporting-Management.index', compact('incidentViews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all(); // Fetch all users for the reviewer dropdown
        return view('Incident-Reporting-Management.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIncidentViewRequest $request)
    {
        $validatedData = $request->validated();

        // Log the Create action
        Log::create([
            'action_performed' => 'Create IncidentView',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the create action
        Audit::create([
            'action_type' => 'Create',
            'resource_affected' => 'IncidentView',
            'previous_state' => null,
            'new_state' => json_encode($validatedData),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        $incidentView = IncidentView::create($validatedData);

        if ($incidentView) {
            return response()->json(['message' => 'Incident View Created Successfully!'], 200);
        }

        return response()->json(['message' => 'Error Occurred While Creating Incident View!'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(IncidentView $incidentView)
    {
        // return view('incidentViews.show', compact('incidentView'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IncidentView $incidentView)
    {
        $users = User::all(); // Fetch all users for the reviewer dropdown

        if ($incidentView) {
            return view('Incident-Reporting-Management.create', compact('incidentView', 'users'));
        }

        return response()->json(['message' => 'Incident View Not Found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIncidentViewRequest $request, IncidentView $incidentView)
    {
        $validatedData = $request->validated();
        $oldState = $incidentView->toArray();

        if ($incidentView->update($validatedData)) {

            // Log the Update action
            Log::create([
                'action_performed' => 'Update IncidentView',
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            // Record an audit trail for the update action
            Audit::create([
                'action_type' => 'Update',
                'resource_affected' => 'IncidentView',
                'previous_state' => json_encode($oldState),
                'new_state' => json_encode($validatedData),
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->roles->pluck('name')->first(),
            ]);

            return response()->json(['message' => 'Incident View Updated Successfully'], 200);
        }

        return response()->json(['message' => 'Error Occurred While Updating Incident View'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncidentView $incidentView)
    {
        $oldState = $incidentView->toArray();

        if ($incidentView->delete()) {

            // Log the Delete action
            Log::create([
                'action_performed' => 'Delete IncidentView',
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            // Record an audit trail for the delete action
            Audit::create([
                'action_type' => 'Delete',
                'resource_affected' => 'IncidentView',
                'previous_state' => json_encode($oldState),
                'new_state' => null,
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->roles->pluck('name')->first(),
            ]);

            return response()->json(['message' => 'Incident View Deleted Successfully'], 200);
        }

        return response()->json(['message' => 'Incident View Not Found'], 404);
    }

    /**
     * Mass delete IncidentViews.
     */
    public function massDeleteIncidentViews(Request $request)
    {
        $ids = $request->ids;
        IncidentView::destroy($ids);

        return response()->json(['message' => 'Incident Views Deleted Successfully']);
    }
}
