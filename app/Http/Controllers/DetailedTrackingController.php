<?php

namespace App\Http\Controllers;

use App\Models\Company;
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

        $trackingData = $pipelineApiTrackingClient->getTrackingData(
            $trackingNumber,
            $searchOption,
            $companyId,
            $zipCode
        );

        $company = null;

        if ($trackingData->ok()) {
            $company = Company::where('pipeline_company_id', $trackingData->object()->data->trackingObject->companyId)
                ->with('theme')
                ->with('backgroundImage')
                ->first();
        }

        return Inertia::render('detailedTracking/Index', [
            'trackingData' => $trackingData->json(),
            'company' => $company,
        ]);
    }
}
