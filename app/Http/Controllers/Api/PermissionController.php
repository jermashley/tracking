<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    /**
     * Display a listing of all permissions.
     */
    public function index(): JsonResponse
    {
        $permissions = Permission::all();

        return response()->json($permissions, Response::HTTP_OK);
    }
}
