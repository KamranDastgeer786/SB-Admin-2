<?php

namespace App\Http\Controllers;

use App\Models\PpeEquipment;
use App\Http\Requests\StorePpeEquipmentRequest;
use App\Http\Requests\UpdatePpeEquipmentRequest;
use Illuminate\Http\Request;
use App\Models\Audit;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class PpeEquipmentController extends Controller
{
    /**
     * Apply middleware for permissions.
     */
    public function __construct()
    {
        $this->middleware('permission:show_ppeEquipments', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_ppeEquipments', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_ppeEquipments', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_ppeEquipments', ['only' => ['destroy', 'massDeletePpeEquipments']]);
    }

    /**
     * Display a listing of PPE equipment.
     */
    public function index()
    {
        $ppeEquipments = PpeEquipment::all();

        // Log the Read action
        Log::create([
            'action_performed' => 'Read PPE Equipment List',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the read action
        Audit::create([
            'action_type' => 'Read',
            'resource_affected' => 'PPE Equipment',
            'previous_state' => null,
            'new_state' => json_encode($ppeEquipments),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        return view('ppe-inventery.index', compact('ppeEquipments'));
    }

    /**
     * Show the form for creating a new PPE equipment.
     */
    public function create()
    {
        return view('ppe-inventery.create');
    }

    /**
     * Store a newly created PPE equipment in storage.
     */
    public function store(StorePpeEquipmentRequest $request)
    {
        $validatedData = $request->validated();
        PpeEquipment::create($validatedData);

        // Log the Create action
        Log::create([
            'action_performed' => 'Create PPE Equipment',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the create action
        Audit::create([
            'action_type' => 'Create',
            'resource_affected' => 'PPE Equipment',
            'previous_state' => null,
            'new_state' => json_encode($validatedData),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        return response()->json(['message' => 'PPE equipment added successfully!']);
    }

    /**
     * Show the form for editing the specified PPE equipment.
     */
    public function edit(PpeEquipment $ppe)
    {
        return view('ppe-inventery.create', compact('ppe'));
    }

    /**
     * Update the specified PPE equipment in storage.
     */
    public function update(UpdatePpeEquipmentRequest $request, PpeEquipment $ppe)
    {
        $validatedData = $request->validated();
        $oldState = $ppe->toArray(); // Capture old state before updating

        $ppe->update($validatedData);
        $newState = $ppe->toArray(); // Capture new state after updating

        // Log the Update action
        Log::create([
            'action_performed' => 'Update PPE Equipment',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the update action
        Audit::create([
            'action_type' => 'Update',
            'resource_affected' => 'PPE Equipment',
            'previous_state' => json_encode($oldState),
            'new_state' => json_encode($newState),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        return response()->json(['message' => 'PPE equipment updated successfully!']);
    }

    /**
     * Remove the specified PPE equipment from storage.
     */
    public function destroy(PpeEquipment $ppe)
    {
        $oldState = $ppe->toArray(); // Capture old state before deletion
        $ppe->delete();

        // Log the Delete action
        Log::create([
            'action_performed' => 'Delete PPE Equipment',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the delete action
        Audit::create([
            'action_type' => 'Delete',
            'resource_affected' => 'PPE Equipment',
            'previous_state' => json_encode($oldState),
            'new_state' => null,
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        return response()->json(['message' => 'PPE equipment deleted successfully!']);
    }
/**
     * Mass delete PPE equipment items.
     */
    public function massDeletePpeEquipments(Request $request)
    {
        $ids = $request->ids;

        // Ensure $ids is an array
        if (is_array($ids)) {
            PpeEquipment::destroy($ids);
            return response()->json(['message' => 'PPE equipment deleted successfully']);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }
}
