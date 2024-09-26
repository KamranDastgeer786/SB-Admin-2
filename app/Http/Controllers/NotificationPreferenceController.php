<?php

namespace App\Http\Controllers;

use App\Models\NotificationPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationPreferenceController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        // Fetch user preferences
        $preferences = Auth::user()->notificationPreferences()->get();

        return view('preferences.index', compact('preferences'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'preferences' => 'array',
            'preferences.*.id' => 'required|exists:notification_preferences,id',
            'preferences.*.opt_in' => 'required|boolean',
        ]);

        foreach ($request->input('preferences') as $preference) {
            NotificationPreference::where('id', $preference['id'])
                ->where('user_id', Auth::id())
                ->update(['opt_in' => $preference['opt_in']]);
        }

        return redirect()->back()->with('success', 'Preferences updated successfully.');
    }
}
