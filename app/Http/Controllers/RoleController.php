<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Audit;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:show_roles', ['only' => ['index']]);
        $this->middleware('permission:create_roles', ['only' => ['store', 'create']]);
        $this->middleware('permission:edit_roles', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete_roles', ['only' => ['destroy', 'massDeleteRoles']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::get(['id', 'name']);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $permissions = Permission::all();
        $groupedPermissions = [];

        foreach ($permissions as $permission) {
            $resource = substr($permission->name, strpos($permission->name, '_') + 1);
            $groupedPermissions[$resource][] = $permission->name;
        }

        //dd($groupedPermissions);

        return view('roles.create', ['permissions' => $groupedPermissions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {

        $validatedData = $request->validated();
        $role = Role::create(['name' => $validatedData['name']]);
        $permissionValues = array_values($validatedData['permissions']);
        $role->syncPermissions($permissionValues);

        // Log the action
        Log::create([
            'user_id' => auth()->id(),
            'action_performed' => 'Created role: ' . $role->name,
            'ip_address' => $request->ip(),
        ]);

        // Store audit trail
        Audit::create([
            'user_id' => auth()->id(),
            'action_type' => 'Role Created',
            'resource_affected' => 'Role: ' . $role->name,
            'previous_state' => null,
            'new_state' => json_encode($role->toArray()),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);


        return response()->json(['message' => "Role Created Successfully!"]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        
        if (!is_null($role)) {
            $permissions = Permission::all();
            $groupedPermissions = [];

            foreach ($permissions as $permission) {
                $resource = substr($permission->name, strpos($permission->name, '_') + 1);
                $groupedPermissions[$resource][] = $permission->name;
            }

            return view('roles.create', ['permissions' => $groupedPermissions, 'role' => $role]);
        }

        return response()->json(['message' => "Role Not Found"], 404);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $validatedData = $request->validated();
        $oldState = $role->toArray();
        $role->update(['name' => $validatedData['name']]);
        $permissions = $validatedData['permissions'];
        $permissionValues = array_keys($permissions);

       // dd( $permissions );

        if ($role->syncPermissions($permissions)) {

            // Log the action
            Log::create([
                'user_id' => auth()->id(),
                'action_performed' => 'Updated role: ' . $role->name,
                'ip_address' => $request->ip(),
           ]);

            // Store audit trail
            Audit::create([
               'user_id' => auth()->id(),
               'action_type' => 'Role Updated',
                'resource_affected' => 'Role: ' . $role->name,
                'previous_state' => json_encode($oldState),
                'new_state' => json_encode($role->toArray()),
                'user_role' => Auth::user()->roles->pluck('name')->first(),
           ]);

            return response()->json(['message' => "Role Updated Successfully!"]);
        }

        return response()->json(['message' => "Some Error Occurred While Updating Role!"], 500);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $oldState = $role->toArray();
        if (!is_null($role)) {
            
            if ($role->delete()) {

                // Log the action
                Log::create([
                  'user_id' => auth()->id(),
                   'action_performed' => 'Delete role: ' . $role->name,
                   'ip_address' => request()->ip(),
                ]);

                // Store audit trail
                Audit::create([
                  'user_id' => auth()->id(),
                   'action_type' => 'Role Delete',
                   'resource_affected' => 'Role: ' . $role->name,
                   'previous_state' => json_encode($oldState),
                    'new_state' => json_encode($role->toArray()),
                    'user_role' => Auth::user()->roles->pluck('name')->first(),
                ]);

                return response()->json(['message' => "Role Deleted Successfully"], 200);
            }
        }

        return response()->json(['message' => "Role Not Found"], 404);
    }

    public function massDeleteRoles(Request $request)
    {
        $ids = $request->ids;
        $roles = Role::findOrFail($ids);

        foreach ($roles as $role) {
            $role->delete();
        }
        return response()->json(['message' => "Deleted Successfully"]);
    }
}

