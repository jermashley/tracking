<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignRolePermissionsRequest;
use App\Http\Requests\StoreUserRolesRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function index(): JsonResponse
    {
        if (Auth::user()->cannot('role:read')) {
            return response()->json(null, Response::HTTP_FORBIDDEN);
        }

        $roles = Role::with('permissions')->get();

        return response()->json($roles);
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(StoreUserRolesRequest $request): JsonResponse
    {
        if (Auth::user()->cannot('role:create')) {
            return response()->json(null, Response::HTTP_FORBIDDEN);
        }

        $validated = $request->validated();

        $role = Role::create(['name' => $validated['name']]);

        if (! empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return response()->json($role->load('permissions'), Response::HTTP_CREATED);
    }

    /**
     * Display the specified role.
     */
    public function show(Role $role): JsonResponse
    {
        if (Auth::user()->cannot('role:read')) {
            return response()->json(null, Response::HTTP_FORBIDDEN);
        }

        return response()->json($role->load('permissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role): JsonResponse
    {
        if (Auth::user()->cannot('role:update')) {
            return response()->json(null, Response::HTTP_FORBIDDEN);
        }

        $validated = $request->validated();

        $role->update(['name' => $validated['name']]);

        if (isset($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return response()->json($role->load('permissions'), Response::HTTP_OK);
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role): JsonResponse
    {
        if (Auth::user()->cannot('role:delete')) {
            return response()->json(null, Response::HTTP_FORBIDDEN);
        }

        $role->delete();

        return response()->json(['message' => 'Role deleted.']);
    }

    /**
     * Assign permissions to a role.
     */
    public function assignPermissions(AssignRolePermissionsRequest $request, Role $role): JsonResponse
    {
        $validated = $request->validated();

        $role->syncPermissions($validated['permissions']);

        return response()->json([
            'message' => 'Permissions assigned successfully.',
            'role' => $role->load('permissions'),
        ], Response::HTTP_OK);
    }
}
