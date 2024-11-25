<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Pipeline\PipelineApiTracking;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function trackShipment(Request $request)
    {
        $shipmentData = new PipelineApiTracking;

        $response = $shipmentData->getTrackingData(
            $request->input('trackingNumber'),
            $request->input('searchOption'),
            $request->input('companyId'),
            $request->input('zipCode')
        );

        return response()->json(json_decode(json_encode($response->json())));
    }
}
