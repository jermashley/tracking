<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\Response as HttpCodes;

class OAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        $socialiteUser = Socialite::driver($provider)->user();

        $emailDomain = substr(strrchr($socialiteUser->getEmail(), '@'), 1);
        $allowedDomains = config('socialite.valid_domains', []);
        $allowedUsers = config('socialite.valid_users', []);

        // Check if the email domain is allowed, and if valid_users is set, also check the email
        if (!in_array($emailDomain, $allowedDomains) || (!empty($allowedUsers) && !in_array($socialiteUser->email, $allowedUsers))) {
            return redirect()->route('login')->withErrors([
                'email' => 'You must be an allowed user to login.',
            ]);
        }

        $userModel = new User;
        $user = $userModel->updateOrCreate([
            'azure_id' => $socialiteUser->id,
        ], [
            'first_name' => $socialiteUser->user['givenName'],
            'last_name' => $socialiteUser->user['surname'],
            'email' => $socialiteUser->email,
            'password' => bcrypt(Str::random(32)),
            'azure_token' => $socialiteUser->token,
            'azure_refresh_token' => $socialiteUser->refreshToken,
            'avatar_url' => $socialiteUser->avatar,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();
        $request->session()->flush();

        return response()->json([], HttpCodes::HTTP_NO_CONTENT);
    }
}
