<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ImageType;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ImageTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $imageTypes = ImageType::get();

        return response()->json($imageTypes, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ImageType $imageType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ImageType $imageType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ImageType $imageType)
    {
        //
    }
}
