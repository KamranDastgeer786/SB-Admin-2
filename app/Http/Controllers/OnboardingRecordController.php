<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOnboardingRecordRequest;
use App\Http\Requests\UpdateOnboardingRecordRequest;
use App\Models\OnboardingRecord;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Audit;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class OnboardingRecordController extends Controller
{

    /**
    * Apply middleware for permissions
    */
    public function __construct()
    {
        $this->middleware('permission:show_onboardingRecords', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_onboardingRecords', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_onboardingRecords', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_onboardingRecords', ['only' => ['destroy', 'massDeleteOnboardingRecords']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $onboardingRecords = OnboardingRecord::with('user')->get();
        // Log the Read action
        // Log::create([
        //     'action_performed' => 'Read Onboarding Record List',
        //     'user_id' => Auth::id(),
        //     'ip_address' => request()->ip(),
        // ]);

        // Record an audit trail for the read action
        Audit::create([
            'action_type' => 'Read',  // Indicating a read action
            'resource_affected' => 'Onboarding Record', // Specify the resource being accessed
            'previous_state' => null, // No previous state needed for read-only action
            'new_state' => json_encode($onboardingRecords), // Capture the state of the resources being read
            'user_id' => Auth::id(), // User ID performing the action
            'user_role' => Auth::user()->roles->pluck('name')->first(), // User role
       ]);
        return view('Onboarding.index', compact('onboardingRecords'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('Onboarding.create', compact('users'));
    }

    /**
    * Store a newly created resource in storage.
    */
  
    public function store(StoreOnboardingRecordRequest $request)
   {
    // Handle the request
    $validatedData = $request->validated();
    // Process the data and create a new onboarding record
    OnboardingRecord::create($validatedData);

    // Log the Create action
    Log::create([
        'action_performed' => 'Onboarding Record',
        'user_id' => Auth::id(),
        'ip_address' => request()->ip(),
    ]);

    // Record an audit trail for the create action
    Audit::create([
        'action_type' => 'Create',
        'resource_affected' => 'Onboarding Record',
        'previous_state' => null, // No previous state for create
        'new_state' => json_encode($validatedData), // Capture the new state of the created assignment
        'user_id' => Auth::id(),
        'user_role' => Auth::user()->roles->pluck('name')->first(),
    ]);


    return response()->json(['message' => 'Onboarding record created successfully.']);
  }

    /**
     * Display the specified resource.
     */
    public function show(OnboardingRecord $onboardingRecord)
    {
        // return view('onboarding-records.show', compact('onboardingRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OnboardingRecord $onboardingRecord)
    {
        $users = User::all();
        return view('Onboarding.create', compact('onboardingRecord', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOnboardingRecordRequest $request, OnboardingRecord $onboardingRecord)
    {
        
        $onboardingRecord->update($request->validated());
       // Capture the previous state for the audit trail
       $previousState = $onboardingRecord->toArray();

        // Log the Update action
        Log::create([
            'action_performed' => 'Update Onboarding Record',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the update action
        Audit::create([
            'action_type' => 'Update',
            'resource_affected' => 'Onboarding Record',
            'previous_state' => json_encode($previousState),  // Capture the previous state
            'new_state' => json_encode($onboardingRecord->toArray()),  // Capture the new state after update
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        return response()->json(['message' => 'success', 'Onboarding record updated successfully.']);
    }        

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OnboardingRecord $onboardingRecord)
    {
        $oldState = $onboardingRecord->toArray(); // Capture the old state before deletion
        $onboardingRecord->delete();

        // Log the Delete action
        Log::create([
           'action_performed' => 'Delete Onboarding Record',
           'user_id' => Auth::id(),
           'ip_address' => request()->ip(),
        ]);

       // Record an audit trail for the delete action
        Audit::create([
            'action_type' => 'Delete',
            'resource_affected' => 'Onboarding Record',
            'previous_state' => json_encode( $oldState),  // Capture the deleted record's state
            'new_state' => null,  // No new state for delete
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);
        return response()->json(['message' => 'Onboarding record deleted successfully.']);
    }

    public function massDeleteOnboardingRecords(Request $request)
    {
        $ids = $request->ids;
        OnboardingRecord::destroy($ids);

        return response()->json(['message' => 'Onboarding record Successfully']);
    }
}