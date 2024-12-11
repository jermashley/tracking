<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageRequest;
use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $imageTypeId = $request->query('image_type_id');

        $imagesQuery = Image::query();

        if ($imageTypeId) {
            $imagesQuery->where('image_type_id', $imageTypeId);
        }

        $images = Image::get();

        return response()->json($images, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request)
    {
        $image = Image::create([
            'name' => $request->name,
            'image_type_id' => $request->image_type_id,
            'file_path' => $request->file('image')->store('images', 'public'),
        ]);

        return response()->json($image, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        $image->delete();

        return response()->json(null, Response::HTTP_OK);
    }
}
