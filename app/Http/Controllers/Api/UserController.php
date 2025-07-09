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
        $users = User::with('roles')->get();

        return response()->json($users, Response::HTTP_OK);
    }

    public function show(User $user): JsonResponse
    {
        $user->load(['roles', 'roles.permissions', 'permissions']);

        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Update the role of a user.
     */
    public function updateRole(Request $request, User $user): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'role.name' => 'required|string|exists:roles,name',
        ]);

        $roleName = $request->input('role.name');

        $user->syncRoles([$roleName]);

        return response()->json($user, Response::HTTP_OK);
    }
}
