<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Services\Pipeline\PipelineApiShipmentCoordinates;
use App\Services\Pipeline\PipelineApiTracking;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DetailedTrackingController extends Controller
{
    public function index(Request $request)
    {
        $trackingNumber = $request->query('trackingNumber') ?? null;
        $searchOption = $request->query('searchOption') ?? null;
        $companyId = $request->query('companyId') ?? null;
        $brand = $request->query('brand') ? strtoupper($request->query('brand')) : null;

        $pipelineApiTrackingClient = new PipelineApiTracking;

        $trackingDataResponse = $pipelineApiTrackingClient->getTrackingData(
            $trackingNumber,
            $searchOption
        );

        // If error in trackingDataResponse, redirect to error page.
        if ($trackingDataResponse->failed() || $trackingDataResponse->clientError() || empty($trackingDataResponse->object()->data)) {
            return redirect(route('trackShipment.notFound', $trackingNumber));
        }

        // Pipeline ID of the company the shipment belongs to.
        $pipelineCompanyId = $trackingDataResponse->object()->data[0]?->companyId;

        $trackingData = $trackingDataResponse->json();

        // Attempt to get local company model from either the slug or the Pipeline company ID.
        $company = Company::findByIdentifier($brand, $companyId, $pipelineCompanyId);

        // If company requires brand and brand is not provided, redirect to error page.
        if ($company?->requires_brand && !$brand) {
            return redirect(route('trackShipment.notFound', $trackingNumber));
        }

        $shipmentCoordinates = null;

        // Get shipment coordinate data if enable_map option is active.
        if ($company?->enable_map) {
            $pipelineApiShipmentCoordinates = new PipelineApiShipmentCoordinates;

            $shipmentCoordinatesResponse = $pipelineApiShipmentCoordinates->getCoordinates(
                $trackingNumber,
                $pipelineCompanyId
            );

            $shipmentCoordinatesResponse->json();

            $shipmentCoordinates = $shipmentCoordinatesResponse->json();
        }

        return Inertia::render('brandedTracking/Index', [
            'initialTrackingData' => $trackingData,
            'initialCompany' => $company,
            'initialShipmentCoordinates' => $shipmentCoordinates,
        ]);
    }

    public function trackingDataNotFound($trackingNumber)
    {
        return Inertia::render('brandedTracking/Error', [
            'trackingNumber' => $trackingNumber,
        ]);
    }
}
