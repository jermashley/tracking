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
        $trackingNumber = $request->query('trackingNumber') ?? '';
        $searchOption = $request->query('searchOption') ?? '';
        $companyId = $request->query('companyId') ?? '';
        $zipCode = $request->query('zipCode') ?? '';

        $pipelineApiTrackingClient = new PipelineApiTracking;

        $trackingDataResponse = $pipelineApiTrackingClient->getTrackingData(
            $trackingNumber,
            $searchOption,
            $companyId,
            $zipCode
        );

        // If error in trackingDataResponse, redirect to error page.
        if ($trackingDataResponse->failed() || $trackingDataResponse->clientError() || empty($trackingDataResponse->object()->data?->trackingObject)) {
            return redirect(route('trackShipment.notFound'));
        }

        // Pipeline ID of the company the shipment belongs to.
        $pipelineCompanyId = $trackingDataResponse->object()->data?->trackingObject?->companyId;

        $trackingData = $trackingDataResponse->json();

        // Attempt to get local company model from Pipeline company ID.
        $company = Company::where('pipeline_company_id', $pipelineCompanyId)
            ->with(['logo', 'theme'])
            ->first();

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

        return Inertia::render('detailedTracking/Index', [
            'trackingData' => $trackingData,
            'company' => $company,
            'shipmentCoordinates' => $shipmentCoordinates,
        ]);
    }

    public function trackingDataNotFound()
    {
        return Inertia::render('detailedTracking/Error');
    }
}
