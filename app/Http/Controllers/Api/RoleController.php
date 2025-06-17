<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignRolePermissionsRequest;
use App\Http\Requests\StoreUserRolesRequest;
use App\Http\Requests\UpdateRoleRequest;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function index(): JsonResponse
    {
        $roles = Role::with('permissions')->get();

        return response()->json($roles);
    }

    public function store(StoreUserRolesRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $role = Role::create(['name' => $validated['name']]);

        if (! empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return response()->json($role->load('permissions'), Response::HTTP_CREATED);
    }

    public function show(Role $role): \Illuminate\Http\JsonResponse
    {
        return response()->json($role->load('permissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role): JsonResponse
    {
        $validated = $request->validated();

        $role->update(['name' => $validated['name']]);

        if (isset($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return response()->json($role->load('permissions'), Response::HTTP_OK);
    }

    public function destroy(Role $role): JsonResponse
    {
        $role->delete();

        return response()->json(['message' => 'Role deleted.']);
    }

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
