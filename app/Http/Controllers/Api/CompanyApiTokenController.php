<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyApiTokenRequest;
use App\Http\Requests\ValidateCompanyApiTokenRequest;
use App\Models\Company;
use App\Models\CompanyApiToken;
use App\Services\Pipeline\PipelineApiShipmentSearch;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CompanyApiTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyApiTokens = CompanyApiToken::all();

        return response()->json($companyApiTokens, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyApiTokenRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $company = Company::whereId($validated['company_id'])
            ->with('apiToken')
            ->first();

        if ($company->apiToken()->exists()) {
            return response()->json(['error' => 'Company already has api token.'], Response::HTTP_CONFLICT);
        }

        $shipmentSearchClient = new PipelineApiShipmentSearch($request->input('api_token'));

        $shipmentSearchResponse = $shipmentSearchClient->searchShipment(
            trackingNumber: $validated['trackingNumber'],
            searchOption: 'bol', // Search by Bill of Lading, as that is how we are validating the API key.
        );

        if ($shipmentSearchResponse->failed() || (int) $shipmentSearchResponse->object()->data[0]->companyId === (int) $request->input('company_id')) {
            return response()->json(['error' => 'Invalid API token.'], Response::HTTP_UNAUTHORIZED);
        }

        CompanyApiToken::create([
            'company_id' => $request->input('company_id'),
            'api_token' => $request->input('api_token'),
            'bol' => $validated['trackingNumber'],
            'is_valid' => true,
        ]);

        return response()->json($company, Response::HTTP_OK);
    }

    /**
     * Validate the status of the API token.
     */
    public function validateToken(ValidateCompanyApiTokenRequest $request, Company $company): JsonResponse
    {
        $company->load('apiToken');

        if (! $company->apiToken) {
            return response()->json(['error' => 'Company does not have an API token.'], Response::HTTP_NOT_FOUND);
        }

        $shipmentSearchClient = new PipelineApiShipmentSearch($company->apiToken->api_token);

        $shipmentSearchResponse = $shipmentSearchClient->searchShipment(
            trackingNumber: $company->apiToken->bol,
            searchOption: 'bol', // Search by Bill of Lading, as that is how we are validating the API key.
            globalSearch: false,
        );

        if ($shipmentSearchResponse->failed() || (int) $shipmentSearchResponse->object()->data[0]->companyId === (int) $company->id) {
            return response()->json(['error' => 'Invalid API token.'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json($company->apiToken->is_valid, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyApiToken $companyApiToken): JsonResponse
    {
        if ($companyApiToken->delete()) {
            return response()->json(['message' => 'API token deleted successfully.'], Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'Failed to delete API token.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
