<?php

namespace App\Services\Pipeline;

use Illuminate\Http\Client\Response;

class PipelineApiShipmentSearch extends PipelineApiBaseService
{
    protected $endpoint;

    protected $apiToken;

    public function __construct(string $apiToken)
    {
        parent::__construct(apiKey: $apiToken);

        $this->endpoint = '/shipmentSearch';
    }

    public function searchShipment(string $quoteId): Response
    {
        $response = $this->makeRequest('POST', $this->endpoint, ['quoteId' => $quoteId]);

        return $response;
    }
}
