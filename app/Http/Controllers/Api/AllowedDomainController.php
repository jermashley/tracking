<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AllowedDomain;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowedDomainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->user()->cannot('allowed_domain:show')) {
            return response()->json(null, Response::HTTP_FORBIDDEN);
        }

        $allowedDomains = AllowedDomain::all();

        return response()->json($allowedDomains, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        if ($request->user()->cannot('allowed_domain:store')) {
            return response()->json(null, Response::HTTP_FORBIDDEN);
        }

        try {
            $domain = $request->input('domain');
            $faviconUrl = $domain ? "https://www.google.com/s2/favicons?domain={$domain}" : null;

            $allowedDomain = AllowedDomain::create([
                ...$request->all(),
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id,
                'favicon_url' => $faviconUrl,
            ]);

            return response()->json($allowedDomain, Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Failed to create allowed domain.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, AllowedDomain $allowedDomain): JsonResponse
    {
        if ($request->user()->cannot('allowed_domain:show')) {
            return response()->json(null, Response::HTTP_FORBIDDEN);
        }

        return response()->json($allowedDomain, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AllowedDomain $allowedDomain): JsonResponse
    {
        if ($request->user()->cannot('allowed_domain:update')) {
            return response()->json(null, Response::HTTP_FORBIDDEN);
        }

        try {
            $domain = $request->input('domain', $allowedDomain->domain);
            $faviconUrl = $domain ? "https://www.google.com/s2/favicons?domain={$domain}" : null;

            $allowedDomain->update([
                ...$request->all(),
                'updated_by' => $request->user()->id,
                'favicon_url' => $faviconUrl,
            ]);

            return response()->json($allowedDomain, Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Failed to update allowed domain.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Toggle the active status of the specified resource.
     */
    public function toggleActiveStatus(Request $request, AllowedDomain $allowedDomain): JsonResponse
    {
        if ($request->user()->cannot('allowed_domain:update')) {
            return response()->json(null, Response::HTTP_FORBIDDEN);
        }

        $allowedDomain->is_active = ! $allowedDomain->is_active;
        $allowedDomain->save();

        return response()->json($allowedDomain, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, AllowedDomain $allowedDomain): JsonResponse
    {
        if ($request->user()->cannot('allowed_domain:destroy')) {
            return response()->json(null, Response::HTTP_FORBIDDEN);
        }

        $allowedDomain->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
