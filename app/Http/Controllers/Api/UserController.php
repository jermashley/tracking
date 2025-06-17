<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $roles = User::all();

        return response()->json($roles, Response::HTTP_OK);
    }

    /**
     * Update the role of a user.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRole(Request $request, User $user): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'role.name' => 'required|string|exists:roles,name',
        ]);

        $roleName = $request->input('role.name');

        $user->syncRoles([$roleName]);

        return response()->json([
            'message' => "Role updated to {$roleName}",
        ], Response::HTTP_OK);
    }
}
