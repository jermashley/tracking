<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AllowedDomain;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AllowedDomainController extends Controller
{
    public function index(): JsonResponse
    {
        $domains = AllowedDomain::all();
        return response()->json($domains, ResponseAlias::HTTP_OK);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'domain' => 'required|string|unique:allowed_domains,domain',
        ]);

        $domain = AllowedDomain::create($validated);

        return response()->json([
            'message' => 'Domain added.',
            'domain' => $domain,
        ], ResponseAlias::HTTP_CREATED);
    }

    public function update(Request $request, AllowedDomain $allowedDomain): JsonResponse
    {
        $validated = $request->validate([
            'domain' => 'required|string|unique:allowed_domains,domain,' . $allowedDomain->id,
        ]);

        $allowedDomain->update($validated);

        return response()->json($allowedDomain, ResponseAlias::HTTP_OK);
    }

    public function destroy(AllowedDomain $allowedDomain): JsonResponse
    {
        $allowedDomain->delete();

        return response()->json([
            'message' => 'Domain deleted.',
        ], ResponseAlias::HTTP_OK);
    }
}
