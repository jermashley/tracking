<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Requests\UpdateCompanyThemeRequest;
use App\Models\Company;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $companies = Company::with(['logo', 'theme'])->get();

        return response()->json($companies, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request): JsonResponse
    {
        $company = Company::create($request->validated());

        return response()->json($company, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company): JsonResponse
    {
        return response()->json($company, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company): JsonResponse
    {
        $company->update($request->validated());

        return response()->json($company, Response::HTTP_OK);
    }

    /**
     * Set the company's theme.
     */
    public function setTheme(Company $company, UpdateCompanyThemeRequest $request): JsonResponse
    {
        $company->theme_id = $request->theme_id;

        $company->save();

        return response()->json($company, Response::HTTP_OK);
    }

    /**
     * Toggle a one of the company's boolean fields.
     */
    public function toggleMapOption(Company $company): JsonResponse
    {
        $company->enable_map = ! $company->enable_map;

        $company->save();

        return response()->json($company, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company): JsonResponse
    {
        $company->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
