<?php

namespace App\Services\Pipeline;

use Illuminate\Http\Client\Response;

class PipelineApiShipmentCoordinates extends PipelineApiBaseService
{
    protected $endpoint;

    public function __construct()
    {
        parent::__construct();

        $this->endpoint = '/TrackingData';
    }

    public function getTrackingData(
        ?string $trackingNumber = '',
        ?string $searchOption = '',
        ?string $companyId = '',
        ?string $zipCode = ''
    ): Response {
        $data = [
            'trackingNum' => $trackingNumber,
            'searchOption' => $searchOption,
            'companyId' => $companyId,
            'zipCode' => $zipCode,
        ];

        $response = $this->makeRequest('POST', $this->endpoint, $data);

        return $response;
    }

    public function getTrackingCoordinates(
        ?string $bolNumber = '',
        ?string $companyId = ''
    ): Response {
        $response
    }
}
