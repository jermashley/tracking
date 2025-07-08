<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/permissions/Index', [
            'permissions' => Permission::select('id', 'name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:permissions,name']);
        $permission = Permission::create(['name' => $request->name]);

        return response()->json($permission, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param Permission $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate(['name' => 'required|string|unique:permissions,name,'.$permission->id]);
        $permission->update(['name' => $request->name]);

        return response()->json($permission, Response::HTTP_OK);
    }

    /**
     * @param Permission $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return response()->json($permission, Response::HTTP_OK);
    }
}
