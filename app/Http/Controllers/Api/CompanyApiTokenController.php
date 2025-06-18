<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCompanyApiTokenRequest;
use App\Models\Company;
use App\Models\CompanyApiToken;
use App\Services\Pipeline\PipelineApiAccessorialsList;
use Illuminate\Http\Request;
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
    public function store(UpdateCompanyApiTokenRequest $request): JsonResponse
    {
        $company = Company::whereId($request->input('company_id'))->with('apiToken')->first();

        if ($company->apiToken()->exists()) {
            return response()->json(['error' => 'Company already has api token.'], Response::HTTP_CONFLICT);
        } else {
            $shipmentTrackingData = new PipelineApiAccessorialsList($request->input('api_token'));

            if(!$shipmentTrackingData->getAccessorialsList()) {
                return response()->json(['error' => 'Invalid API token.'], Response::HTTP_UNAUTHORIZED);
            }

            $apiToken = new CompanyApiToken([
                'company_id' => $request->input('company_id'),
                'api_token' => $request->input('api_token'),
                'is_valid' => true,
            ]);
            $company->apiToken()->save($apiToken);
            return response()->json($company, Response::HTTP_OK);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyApiToken $companyApiToken)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CompanyApiToken $companyApiToken)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyApiToken $companyApiToken): JsonResponse
    {
        if($companyApiToken->delete()) {
            return response()->json(['message' => 'API token deleted successfully.'], Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'Failed to delete API token.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
