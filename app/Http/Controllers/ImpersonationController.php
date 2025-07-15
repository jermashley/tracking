<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ImpersonationController extends Controller
{
    public function impersonate(Request $request, $userId)
    {

        $userToImpersonate = User::whereId($userId)->first();

        if ($userToImpersonate->hasRole('Super Admin')) {
            return response()->json(null, Response::HTTP_FORBIDDEN);
        }

        $request->session()->put('impersonate_original_id', Auth::id());

        Auth::guard('web')->login($userToImpersonate);

        return redirect(route('home'))
            ->with('status', 'You are now impersonating user ID '.$userToImpersonate->id.'.');
    }

    public function stopImpersonate(Request $request)
    {
        $originalId = $request->session()->pull('impersonate_original_id');

        if ($originalId) {
            $originalUser = User::whereId($originalId)->first();

            if ($originalUser) {
                $request->session()->forget('impersonate_original_id');

                Auth::guard('web')->login($originalUser);

                return redirect(route('admin.users.index'))
                    ->with('status', 'You have returned to your account.')
                    ->with('reload', true);
            }
        }

        Auth::guard('web')->logout();

        return redirect(route('home'))
            ->with('status', 'Impersonation ended. Please log in.');
    }
}
