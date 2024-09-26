<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComplianceRequest;
use App\Http\Requests\UpdateComplianceRequest;
use App\Models\Compliance;
use App\Models\User;
use App\Models\Audit;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplianceController extends Controller
{
    /**
    * Apply middleware for permissions
    */
    public function __construct()
    {
        $this->middleware('permission:show_compliances', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_compliances', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_compliances', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_compliances', ['only' => ['destroy', 'massDeleteCompliances']]);
    }

    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $compliances = Compliance::with(relations: 'user')->get();

        // Record an audit trail for the read action
        Audit::create([
            'action_type' => 'Read',
            'resource_affected' => 'Compliance',
            'previous_state' => null,
            'new_state' => json_encode($compliances),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        return view('PPE-equipment-management-onboarding.Compliance.index', compact('compliances'));
    }

    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        $users = User::all();
        return view('PPE-equipment-management-onboarding.Compliance.create', compact('users'));
    }

    /**
    * Store a newly created resource in storage.
    */
    public function store(StoreComplianceRequest $request)
    {
        $validatedData = $request->validated();

        // Log the Create action
        Log::create([
            'action_performed' => 'Create Compliance',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the create action
        Audit::create(attributes: [
            'action_type' => 'Create',
            'resource_affected' => 'Compliance',
            'previous_state' => null,
            'new_state' => json_encode($validatedData),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        $compliance = Compliance::create($validatedData);

        if ($compliance) {
            return response()->json(['message' => 'Compliance Created Successfully!'], 200);
        }

        return response()->json(['message' => 'Error Occurred While Creating Compliance!'], 500);
    }

    /**
    * Display the specified resource.
    */
    public function show(Compliance $compliance)
    {
        // return view('compliances.show', compact('compliance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Compliance $compliance)
    {
        $users = User::all();

        if ($compliance) {
            return view('PPE-equipment-management-onboarding.Compliance.create', compact('compliance', 'users'));
        }

        return response()->json(['message' => 'Compliance Not Found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComplianceRequest $request, Compliance $compliance)
    {
        $validatedData = $request->validated();
        $oldState = $compliance->toArray();

        if ($compliance->update($validatedData)) {

            // Log the Update action
            Log::create([
                'action_performed' => 'Update Compliance',
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            // Record an audit trail for the update action
            Audit::create([
                'action_type' => 'Update',
                'resource_affected' => 'Compliance',
                'previous_state' => json_encode($oldState),
                'new_state' => json_encode($validatedData),
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->roles->pluck('name')->first(),
            ]);

            return response()->json(['message' => 'Compliance Updated Successfully'], 200);
        }

        return response()->json(['message' => 'Error Occurred While Updating Compliance'], 500);
    }

    /**
    * Remove the specified resource from storage.
    */
    public function destroy(Compliance $compliance)
    {
        $oldState = $compliance->toArray();

        if ($compliance->delete()) {

            // Log the Delete action
            Log::create([
                'action_performed' => 'Delete Compliance',
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            // Record an audit trail for the delete action
            Audit::create([
                'action_type' => 'Delete',
                'resource_affected' => 'Compliance',
                'previous_state' => json_encode($oldState),
                'new_state' => null,
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->roles->pluck('name')->first(),
            ]);

            return response()->json(['message' => 'Compliance Deleted Successfully'], 200);
        }

        return response()->json(['message' => 'Compliance Not Found'], 404);
    }

    /**
    * Mass delete Compliances.
    */
    public function massDeleteCompliances(Request $request)
    {
        $ids = $request->ids;
        Compliance::destroy($ids);

        return response()->json(['message' => 'Compliances Deleted Successfully']);
    }
}
