<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;




class SwitchRoleController extends Controller
{
    public function __invoke(Role $role)
    {

        // Ensure the user has the given role
        //abort_unless(auth()->user()->hasRole($role->name), 404);

        // Update the user's current role
        //auth()->user()->update(['current_role_id' => $role->id]);

        // Redirect to the dashboard (adjust the route as needed)
        return to_route('dashboard');
    }
}
