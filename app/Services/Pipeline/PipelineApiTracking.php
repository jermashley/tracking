<?php

namespace App\Services\Pipeline;

use Illuminate\Http\Client\Response;

class PipelineApiTracking extends PipelineApiBaseService
{
    protected $endpoint;

    public function __construct()
    {
        parent::__construct();

        $this->endpoint = '/shipmentSearch';
    }

    public function getTrackingData(
        ?string $trackingNumber = '',
        ?string $searchOption = '',
    ): Response {
        $data = [
            'trackNum' => $trackingNumber,
            'searchOption' => $searchOption,
            'globalSearch' => true,
        ];

        $response = $this->makeRequest('POST', $this->endpoint, $data);

        return $response;
    }
}
