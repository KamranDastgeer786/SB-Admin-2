<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use App\Models\Inventory;
use App\Models\Audit;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
    * Apply middleware for permissions
    */
    public function __construct()
    {
        $this->middleware('permission:show_inventories', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_inventories', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_inventories', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_inventories', ['only' => ['destroy', 'massDeleteInventories']]);
    }

    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $inventories = Inventory::all();

        // Record an audit trail for the read action
        Audit::create([
            'action_type' => 'Read',
            'resource_affected' => 'Inventory',
            'previous_state' => null,
            'new_state' => json_encode($inventories),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        return view('PPE-equipment-management-onboarding.index', compact('inventories'));
    }

    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        return view('PPE-equipment-management-onboarding.create');
    }

    /**
    * Store a newly created resource in storage.
    */
    public function store(StoreInventoryRequest $request)
    {
        $validatedData = $request->validated();

        // Log the Create action
        Log::create([
            'action_performed' => 'Create Inventory',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the create action
        Audit::create([
            'action_type' => 'Create',
            'resource_affected' => 'Inventory',
            'previous_state' => null,
            'new_state' => json_encode($validatedData),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        $inventory = Inventory::create($validatedData);

        if ($inventory) {
            return response()->json(['message' => 'Inventory Created Successfully!'], 200);
        }

        return response()->json(['message' => 'Error Occurred While Creating Inventory!'], 500);
    }

    /**
    * Display the specified resource.
    */
    public function show(Inventory $inventory)
    {
        // return view('inventory.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        if ($inventory) {
            return view('PPE-equipment-management-onboarding.create', compact('inventory'));
        }

        return response()->json(['message' => 'Inventory Not Found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInventoryRequest $request, Inventory $inventory)
    {
        $validatedData = $request->validated();
        $oldState = $inventory->toArray();

        if ($inventory->update($validatedData)) {

            // Log the Update action
            Log::create([
                'action_performed' => 'Update Inventory',
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            // Record an audit trail for the update action
            Audit::create([
                'action_type' => 'Update',
                'resource_affected' => 'Inventory',
                'previous_state' => json_encode($oldState),
                'new_state' => json_encode($validatedData),
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->roles->pluck('name')->first(),
            ]);

            return response()->json(['message' => 'Inventory Updated Successfully'], 200);
        }

        return response()->json(['message' => 'Error Occurred While Updating Inventory'], 500);
    }

    /**
    * Remove the specified resource from storage.
    */
    public function destroy(Inventory $inventory)
    {
        $oldState = $inventory->toArray();

        if ($inventory->delete()) {

            // Log the Delete action
            Log::create([
                'action_performed' => 'Delete Inventory',
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            // Record an audit trail for the delete action
            Audit::create([
                'action_type' => 'Delete',
                'resource_affected' => 'Inventory',
                'previous_state' => json_encode($oldState),
                'new_state' => null,
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->roles->pluck('name')->first(),
            ]);

            return response()->json(['message' => 'Inventory Deleted Successfully'], 200);
        }

        return response()->json(['message' => 'Inventory Not Found'], 404);
    }

    /**
    * Mass delete Inventories.
    */
    public function massDeleteInventories(Request $request)
    {
        $ids = $request->ids;
        Inventory::destroy($ids);

        return response()->json(['message' => 'Inventories Deleted Successfully']);
    }
}
