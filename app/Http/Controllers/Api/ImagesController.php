<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageRequest;
use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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

        $images = $imagesQuery->with('imageType')->get();

        return response()->json($images, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request): JsonResponse
    {
        $validated = $request->validated();

        try {
            $filePath = $validated['image']->store('images', 'spaces');

            if (! $filePath) {
                throw new \Exception('File path is empty');
            }

            $image = new Image([
                'name' => $validated['name'],
                'image_type_id' => $validated['image_type_id'],
                'file_path' => $filePath,
            ]);

            $image->save();

            return response()->json($image, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error('Error storing image: '.$e->getMessage());

            return response()->json(['error' => 'Failed to store image'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
