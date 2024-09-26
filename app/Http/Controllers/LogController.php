<?php

namespace App\Http\Controllers;
use App\Models\Log;

use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all logs
        $logs = Log::all();

        // Pass the logs to the index view
        return view('audits.logs.index', compact('logs'));
    }

    
}
