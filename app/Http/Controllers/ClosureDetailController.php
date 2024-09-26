<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClosureDetailRequest;
use App\Http\Requests\UpdateClosureDetailRequest;
use App\Models\ClosureDetail;
use App\Models\IncidentView;
use App\Models\Audit;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClosureDetailController extends Controller
{
    /**
     * Apply middleware for permissions.
     */
    public function __construct()
    {
        $this->middleware('permission:show_closure_details', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_closure_details', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_closure_details', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_closure_details', ['only' => ['destroy', 'massDeleteClosureDetails']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $closureDetails = ClosureDetail::with('incidentView')->get();

        // Record an audit trail for the read action
        Audit::create([
            'action_type' => 'Read',
            'resource_affected' => 'ClosureDetail',
            'previous_state' => null,
            'new_state' => json_encode($closureDetails),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        return view('Incident-Reporting-Management.closure-details.index', compact('closureDetails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $incidentViews = IncidentView::all();
        return view('Incident-Reporting-Management.closure-details.crerate', compact('incidentViews'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClosureDetailRequest $request)
    {
        $validatedData = $request->validated();

        // Log the Create action
        Log::create([
            'action_performed' => 'Create Closure Detail',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the create action
        Audit::create([
            'action_type' => 'Create',
            'resource_affected' => 'ClosureDetail',
            'previous_state' => null,
            'new_state' => json_encode($validatedData),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        $closureDetail = ClosureDetail::create($validatedData);

        if ($closureDetail) {
            return response()->json(['message' => 'Closure Detail Created Successfully!'], 200);
        }

        return response()->json(['message' => 'Error Occurred While Creating Closure Detail!'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(ClosureDetail $closureDetail)
    {
        // return view('closure-details.show', compact('closureDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClosureDetail $closureDetail)
    {
        //dd($closureDetail);
        $incidentViews = IncidentView::all();

        if ($closureDetail) {
            return view('Incident-Reporting-Management.closure-details.crerate', compact('closureDetail', 'incidentViews'));
        }

        return response()->json(['message' => 'Closure Detail Not Found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClosureDetailRequest $request, ClosureDetail $closureDetail)
    {
        $validatedData = $request->validated();
        $oldState = $closureDetail->toArray();

        if ($closureDetail->update($validatedData)) {

            // Log the Update action
            Log::create([
                'action_performed' => 'Update Closure Detail',
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            // Record an audit trail for the update action
            Audit::create([
                'action_type' => 'Update',
                'resource_affected' => 'ClosureDetail',
                'previous_state' => json_encode($oldState),
                'new_state' => json_encode($validatedData),
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->roles->pluck('name')->first(),
            ]);

            return response()->json(['message' => 'Closure Detail Updated Successfully'], 200);
        }

        return response()->json(['message' => 'Error Occurred While Updating Closure Detail'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClosureDetail $closureDetail)
    {
        $oldState = $closureDetail->toArray();

        if ($closureDetail->delete()) {

            // Log the Delete action
            Log::create([
                'action_performed' => 'Delete Closure Detail',
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            // Record an audit trail for the delete action
            Audit::create([
                'action_type' => 'Delete',
                'resource_affected' => 'ClosureDetail',
                'previous_state' => json_encode($oldState),
                'new_state' => null,
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->roles->pluck('name')->first(),
            ]);

            return response()->json(['message' => 'Closure Detail Deleted Successfully'], 200);
        }

        return response()->json(['message' => 'Closure Detail Not Found'], 404);
    }

    /**
     * Mass delete Closure Details.
     */
    public function massDeleteClosureDetails(Request $request)
    {
        $ids = $request->ids;
        ClosureDetail::destroy($ids);

        return response()->json(['message' => 'Closure Details Deleted Successfully']);
    }
}
