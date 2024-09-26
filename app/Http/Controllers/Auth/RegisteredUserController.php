<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\NotificationPreference;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistrationMail;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

       // Assign the 'defaultuser' role to the new user
        $defaultRole = Role::where('name', 'defaultuser')->first();
        if ($defaultRole) {
            $user->assignRole($defaultRole);
        }
        // Trigger the Registered event
        event(new Registered($user));

        // Prepare email content
        $subject = 'Welcome to Our Dashboard, ' . $user->name;
        // $message = 'Thank you for registering, ' . $user->name . '! We are excited to have you onboard.';
        $message = view('emails.user_registration', ['user' => $user])->render();

            // Send the registration email directly
            Mail::to($user->email)->send(new UserRegistrationMail($message, $user, $subject));
        // Send the registration email directly
        // Mail::to($user->email)->send(new UserRegistrationMail($message, $subject));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}