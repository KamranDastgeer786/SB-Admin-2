<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

use App\Models\IncidentReportSubmission;
use App\Models\ClosureDetail;

class DashboardController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    
        $totalUsers = User::count(); // This line defines the variable.
        $activeIncident = IncidentReportSubmission::count();
        $inventorySummary = ClosureDetail::count();
        return view('dashboard', compact('totalUsers','activeIncident','inventorySummary')); // This passes it to the view.



    }

    public function switchDashboard($roleId)
    {
    
       $role = Role::find($roleId);
       if ($role && auth()->user()->hasRole($role->name)) {
        session(['switched_role' => $role->name]);
        return redirect()->back()->with('success', 'Role switched successfully to ' . $role->name);
    }

    return redirect()->back()->with('error', 'Invalid role or no permission to switch roles.');

    }
}
