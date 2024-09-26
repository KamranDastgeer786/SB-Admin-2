<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    /**
     * Redirect to Google for authentication.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback.
     */
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = $this->findOrCreateUser($googleUser, 'google');

        Auth::login($user);

        return redirect()->intended('/dashboard'); // Change to your intended route
    }

    /**
     * Redirect to Facebook for authentication.
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Handle Facebook callback.
     */
    public function handleFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();

        $user = $this->findOrCreateUser($facebookUser, 'facebook');

        Auth::login($user);

        return redirect()->intended('/dashboard'); // Change to your intended route
    }

    /**
     * Find or create a user based on provider information.
     */
    protected function findOrCreateUser($providerUser, $provider)
    {
        $user = User::where('email', $providerUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'password' => Hash::make(Str::random(24)),
                'provider' => $provider,
                'provider_id' => $providerUser->getId(),
            ]);
        }

        return $user;
    }
}