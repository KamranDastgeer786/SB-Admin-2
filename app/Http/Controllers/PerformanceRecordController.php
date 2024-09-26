<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePerformanceRecordRequest;
use App\Http\Requests\UpdatePerformanceRecordRequest;
use App\Models\PerformanceRecord;
use App\Models\DriverProfile;
use App\Models\Audit;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerformanceRecordController extends Controller
{
    /**
     * Apply middleware for permissions
     */
    public function __construct()
    {
        $this->middleware('permission:show_performance_records', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_performance_records', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_performance_records', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_performance_records', ['only' => ['destroy', 'massDeletePerformanceRecords']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $performanceRecords = PerformanceRecord::with('driverProfile')->get();

        // Record an audit trail for the read action
        Audit::create([
            'action_type' => 'Read',
            'resource_affected' => 'Performance Record',
            'previous_state' => null,
            'new_state' => json_encode($performanceRecords),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        return view('performance-records.index', compact('performanceRecords'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $driverProfiles = DriverProfile::all();
        return view('performance-records.create', compact('driverProfiles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePerformanceRecordRequest $request)
    {
        $validatedData = $request->validated();

        // Log the Create action
        Log::create([
            'action_performed' => 'Create Performance Record',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the create action
        Audit::create([
            'action_type' => 'Create',
            'resource_affected' => 'Performance Record',
            'previous_state' => null,
            'new_state' => json_encode($validatedData),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        $performanceRecord = PerformanceRecord::create($validatedData);

        if ($performanceRecord) {
            return response()->json(['message' => 'Performance Record Created Successfully!'], 200);
        }

        return response()->json(['message' => 'Error Occurred While Creating Performance Record!'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(PerformanceRecord $performanceRecord)
    {
        // return view('performance-records.show', compact('performanceRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerformanceRecord $performanceRecord)
    {
        //dd($performanceRecord);
        $driverProfiles = DriverProfile::all();

        if ($performanceRecord) {
            return view('performance-records.create', compact('performanceRecord', 'driverProfiles'));
        }

        return response()->json(['message' => 'Performance Record Not Found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePerformanceRecordRequest $request, PerformanceRecord $performanceRecord)
    {
        $validatedData = $request->validated();
        $oldState = $performanceRecord->toArray();

        if ($performanceRecord->update($validatedData)) {

            // Log the Update action
            Log::create([
                'action_performed' => 'Update Performance Record',
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            // Record an audit trail for the update action
            Audit::create([
                'action_type' => 'Update',
                'resource_affected' => 'Performance Record',
                'previous_state' => json_encode($oldState),
                'new_state' => json_encode($validatedData),
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->roles->pluck('name')->first(),
            ]);

            return response()->json(['message' => 'Performance Record Updated Successfully'], 200);
        }

        return response()->json(['message' => 'Error Occurred While Updating Performance Record'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerformanceRecord $performanceRecord)
    {
        $oldState = $performanceRecord->toArray();

        if ($performanceRecord->delete()) {

            // Log the Delete action
            Log::create([
                'action_performed' => 'Delete Performance Record',
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            // Record an audit trail for the delete action
            Audit::create([
                'action_type' => 'Delete',
                'resource_affected' => 'Performance Record',
                'previous_state' => json_encode($oldState),
                'new_state' => null,
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->roles->pluck('name')->first(),
            ]);

            return response()->json(['message' => 'Performance Record Deleted Successfully'], 200);
        }

        return response()->json(['message' => 'Performance Record Not Found'], 404);
    }

    /**
     * Mass delete Performance Records.
     */
    public function massDeletePerformanceRecords(Request $request)
    {
        $ids = $request->ids;
        PerformanceRecord::destroy($ids);

        return response()->json(['message' => 'Performance Records Deleted Successfully']);
    }
}
