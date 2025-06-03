<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\Pipeline\PipelineApiShipmentCoordinates;
use App\Services\Pipeline\PipelineApiTracking;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TrackingController extends Controller
{
    public function trackingStatuses(Request $request): JsonResponse
    {
        $shipmentTrackingData = new PipelineApiTracking;

        $trackingDataResponse = $shipmentTrackingData->getTrackingData(
            $request->input('trackingNumber'),
            $request->input('searchOption'),
        );

        // If error in trackingDataResponse, redirect to error page.
        if ($trackingDataResponse->failed() || $trackingDataResponse->clientError() || empty($trackingDataResponse->object()->data)) {
            return response()->json([
                'error' => 'Tracking data not found or invalid.',
            ], Response::HTTP_NOT_FOUND);
        }

        // Pipeline ID of the company the shipment belongs to.
        $pipelineCompanyId = $trackingDataResponse->object()->data[0]?->companyId;

        $trackingData = $trackingDataResponse->json();

        // Attempt to get local company model from either the slug or the Pipeline company ID.
        $company = Company::findByIdentifier(null, $request->input('companyId'), $pipelineCompanyId);

        $shipmentCoordinates = null;

        // Get shipment coordinate data if enable_map option is active.
        if ($company?->enable_map) {
            $pipelineApiShipmentCoordinates = new PipelineApiShipmentCoordinates;

            $shipmentCoordinatesResponse = $pipelineApiShipmentCoordinates->getCoordinates(
                $request->input('trackingNumber'),
                $pipelineCompanyId
            );

            $shipmentCoordinatesResponse->json();

            $shipmentCoordinates = $shipmentCoordinatesResponse->json();
        }

        return response()->json([
            'trackingData' => $trackingData,
            'company' => $company,
            'shipmentCoordinates' => $shipmentCoordinates,
        ], Response::HTTP_OK);
    }

    public function shipmentCoordinates(Request $request): JsonResponse
    {
        $shipmentCoordinates = new PipelineApiShipmentCoordinates;

        $response = $shipmentCoordinates->getCoordinates(
            $request->input('trackingNumber'),
            $request->input('pipelineCompanyId')
        );

        $company = Company::findByIdentifier(null, null, $request->input('pipelineCompanyId'));

        if (!$company || $company->enable_map === false) {
            return response()->json([
                'error' => 'Map feature is disabled for this company.',
            ], Response::HTTP_FORBIDDEN);
        }

        return response()->json($response->json(), Response::HTTP_OK);
    }
}
