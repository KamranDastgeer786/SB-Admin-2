<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Audit;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:show_users', ['only' => ['index']]);
        $this->middleware('permission:create_users', ['only' => ['store', 'create']]);
        $this->middleware('permission:edit_users', ['only' => ['update', 'edit', 'updateActiveStatus']]);
        $this->middleware('permission:delete_users', ['only' => ['destroy', 'massDeleteUsers']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        // Log the Read action
        Log::create([
            'action_performed' => 'Read Users List',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::get(['id', 'name']);
       return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['active'] = $validatedData['active'] === 'on' ? true : false;
        $user = User::create($validatedData);

        if (!is_null($user)) {
            if (isset($validatedData['roles']) && is_array($validatedData['roles'])) {
                $roleIds = $validatedData['roles'];
                $roles = Role::findOrFail($roleIds);
                $user->syncRoles($roles);
            }

            // Log the Read action
            Log::create([
                'action_performed' => 'Create Users',
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            // Log the Create action
            Audit::create([
                'action_type' => 'Create',
                'resource_affected' => 'User',
                'previous_state' => null,
                'new_state' => json_encode($validatedData),
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->roles->pluck('name')->first(),
            ]);
            return response()->json(['message' => "User Created Successfully!"], 200);
        }

        return response()->json(['message' => "Some Error Occurred While Creating User!"], 500);
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
    public function edit(User $user)
    {
        //dd($user);
        if (!is_null($user)) {
            $roles = Role::get(['id', 'name']);
            return view('users.create', compact('roles', 'user'));
        }
    
        return response()->json(['message' => "User Not Found"], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
    
        $validatedData = $request->validated();
        //dd($validatedData );
        $validatedData['active'] = $validatedData['active'] === 'on' ? true : false;
    
        if ($validatedData['password'] == null) {
            unset($validatedData['password']);
        }
    
        if (isset($validatedData['roles']) && is_array($validatedData['roles'])) {
            $roleIds = $validatedData['roles'];
            $roles = Role::findOrFail($roleIds);
            $user->syncRoles($roles);
        }
    
        if ($user->update($validatedData)) {
            return response()->json(['message' => "User Updated Successfully"], 200);
        }
    
        return response()->json(['message' => "Some Error Occurred While Updating User"], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        
        
        if (!is_null($user)) {
            $oldData = $user->getOriginal();
            // Log the Delete action
            if ($user->delete()) {

                // Log the Read action
                Log::create([
                   'action_performed' => 'Delete Users',
                   'user_id' => Auth::id(),
                   'ip_address' => request()->ip(),
                ]);

                Audit::create([
                    'action_type' => 'Delete',
                    'resource_affected' => 'User',
                    'previous_state' => json_encode($oldData),
                    'new_state' => null,
                    'user_id' => Auth::id(),
                    'user_role' => Auth::user()->roles->pluck('name')->first(),
                ]);
                return response()->json(['message' => "User Deleted Successfully"], 200);
            }
        }

        return response()->json(['message' => "User Not Found"], 404);
    }

    public function massDeleteUsers(Request $request)
    {
        $ids = $request->ids;
       $users = User::findOrFail($ids);

        foreach ($users as $user) {
            $user->delete();
        }
       return response()->json(['message' => "Deleted Successfully"]);
    }


    public function updateActiveStatus(Request $request)
    {
        $userId = $request->id;
        $user = User::findOrFail($userId);

        if (!is_null($user)) {
            if ($request->has('activeStatus')) {
               $user->update(['active' => $request->boolean('activeStatus')]);
            }

            return response()->json(['message' => 'Status Updated Successfully'], 200);
        }
    }
}
