<?php

namespace App\Http\Controllers;
use App\Models\Audit;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all audit records from the database
        $audits = Audit::all();

        // Return the index view with the audits data
        return view('audits.index', compact('audits'));
    }

    
}
