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
        ?string $trackingNumber = '',
        ?string $apiKey = null
    ): Response {
        $data = [
            'RequestOptions' => [
                'testMode' => false,
            ],
            'Request' => [
                'BOLNumber' => $trackingNumber,
            ],
        ];
        $this->headers['apiKey'] = $apiKey;
        return $this->makeRequest('POST', $this->endpoint, $data);
    }
}
