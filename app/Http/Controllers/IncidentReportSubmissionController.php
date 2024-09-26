<?php

namespace App\Http\Controllers;

use App\Models\IncidentReportSubmission;
use App\Models\User;
use App\Http\Requests\StoreIncidentReportRequest;
use App\Http\Requests\UpdateIncidentReportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Audit;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class IncidentReportSubmissionController extends Controller
{
    /**
     * Apply middleware for permissions
     */
    public function __construct()
    {
        $this->middleware('permission:show_incidentReports', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_incidentReports', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_incidentReports', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_incidentReports', ['only' => ['destroy', 'massDeleteIncidentReports']]);
    }

    /**
     * Display a list of all incident reports.
     */
    public function index()
    {
        $incidentReports = IncidentReportSubmission::with('user')->get();
        // Record an audit trail for the read action
        Audit::create([
            'action_type' => 'Read',  // Indicating a read action
            'resource_affected' => 'Incident Report', // Specify the resource being accessed
            'previous_state' => null, // No previous state needed for read-only action
            'new_state' => json_encode($incidentReports), // Capture the state of the resources being read
            'user_id' => Auth::id(), // User ID performing the action
            'user_role' => Auth::user()->roles->pluck('name')->first(), // User role
       ]);
        return view('incident-report-submission.index', compact('incidentReports'));
    }

    /**
     * Show the form for creating a new incident report.
     */
    public function create()
    {
        $users = User::all();
        return view('incident-report-submission.create', compact('users'));
    }

    /**
     * Store a newly created incident report in the database.
     */
    public function store(StoreIncidentReportRequest $request)
    {
        $validatedData = $request->validated();

        // Handle file upload for attachments
        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('incident_attachments', $fileName, 'public');
            $validatedData['attachments'] = 'storage/' . $filePath;
        }

        // Log the Create action
        Log::create([
            'action_performed' => 'Create Incident Report',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the create action
        Audit::create([
            'action_type' => 'Create',
            'resource_affected' => 'Incident Report',
            'previous_state' => null, // No previous state for create
            'new_state' => json_encode($validatedData), // Capture the new state of the created assignment
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        IncidentReportSubmission::create($validatedData);

        return response()->json(['message' => 'Incident report submitted successfully!']);
    }

    /**
     * Display the specified incident report.
     */
    public function show(IncidentReportSubmission $incidentReport)
    {
        // return view('incident-report-submission.show', compact('incidentReport'));
    }

    /**
     * Show the form for editing the specified incident report.
     */
    public function edit(IncidentReportSubmission $incidentReport)
    {
        $users = User::all();
        return view('incident-report-submission.create', compact('incidentReport', 'users'));
    }

    /**
     * Update the specified incident report in the database.
     */
    public function update(UpdateIncidentReportRequest $request, IncidentReportSubmission $incidentReport)
    {
        // Capture the previous state for the audit trail
        $previousState = $incidentReport->toArray();
        $validatedData = $request->validated();

        // Check if a new attachment is uploaded
        if ($request->hasFile('attachments')) {
            // Remove the old attachment if it exists
            if ($incidentReport->attachments && Storage::exists($incidentReport->attachments)) {
                Storage::delete($incidentReport->attachments);
            }

            // Upload the new file
            $file = $request->file('attachments');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('incident_attachments', $fileName, 'public');
            $validatedData['attachments'] = 'storage/' . $filePath;
        }

        $incidentReport->update($validatedData);

        // Log the Update action
        Log::create([
            'action_performed' => 'Update Incident Report',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the update action
        Audit::create([
            'action_type' => 'Update',
            'resource_affected' => 'Incident Report',
            'previous_state' => json_encode($previousState), // Capture the previous state
            'new_state' => json_encode($incidentReport->toArray()), // Capture the new state after update
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        return response()->json(['message' => 'Incident report updated successfully!']);
    }

    /**
     * Remove the specified incident report from the database.
     */
    public function destroy(IncidentReportSubmission $incidentReport)
    {
        // Capture the state of the record before deletion
        $previousState = $incidentReport->toArray();

        if ($incidentReport->attachments && Storage::exists($incidentReport->attachments)) {
            Storage::delete($incidentReport->attachments);
        }

        $incidentReport->delete();

        // Log the Delete action
        Log::create([
            'action_performed' => 'Delete Incident Report',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the delete action
        Audit::create([
           'action_type' => 'Delete',
           'resource_affected' => 'Incident Report',
           'previous_state' => json_encode($previousState), // Capture the deleted record's state
           'new_state' => null, // No new state for delete
           'user_id' => Auth::id(),
           'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        return response()->json(['message' => 'Incident report deleted successfully!']);
    }

    /**
     * Mass delete multiple incident reports.
     */
    public function massDeleteIncidentReports(Request $request)
    {
        $ids = $request->ids;
        IncidentReportSubmission::destroy($ids);

        return response()->json(['message' => 'Incident reports deleted successfully!']);
    }
}