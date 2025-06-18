<?php

namespace App\Services\Pipeline;

use Illuminate\Http\Client\Response;

class PipelineApiDocuments extends PipelineApiBaseService
{
    protected $endpoint;

    public function __construct()
    {
        parent::__construct();

        $this->endpoint = '/Execute/GetDocuments';
    }

    public function getShipmentDocuments(
        ?string $trackingNumber = ''
    ): Response {
        $data = [
            'RequestOptions' => [
                'testMode' => false,
            ],
            'Request' => [
                'BOLNumber' => $trackingNumber,
            ],
        ];

        $response = $this->makeRequest('POST', $this->endpoint, $data);

        return $response;
    }
}
