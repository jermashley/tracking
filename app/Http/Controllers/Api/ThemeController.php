<?php

namespace App\Http\Controllers\Api;

use App\Actions\GenerateThemeColors;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreThemeRequest;
use App\Http\Requests\UpdateThemeRequest;
use App\Models\Theme;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $themes = Theme::all();

        return response()->json($themes, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreThemeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $colors = GenerateThemeColors::execute($data);

        $theme = (new Theme)->create([
            'name' => $request->input('name'),
            'colors' => $colors,
            'radius' => $request->input('radius') ?? '0.5rem',
            'is_system' => $request->input('is_system', false),
            'derive_from' => $request->input('derive_from'),
        ]);

        return response()->json($theme, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Theme $theme)
    {
        return response()->json($theme, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateThemeRequest $request, Theme $theme): JsonResponse
    {
        $data = $request->validated();
        $colors = GenerateThemeColors::execute($data);

        $theme->update([
            'name' => $request->input('name'),
            'colors' => $colors,
            'radius' => $request->input('radius') ?? '0.5rem',
            'is_system' => $request->input('is_system', false),
            'derive_from' => $request->input('derive_from'),
        ]);

        return response()->json($theme, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theme $theme)
    {
        $theme->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
