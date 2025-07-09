<?php

namespace App\Services\Pipeline;

use Illuminate\Http\Client\Response;

class PipelineApiAccessorialsList extends PipelineApiBaseService
{
    protected $endpoint;

    protected $apiToken;

    public function __construct(string $apiToken)
    {
        parent::__construct(apiKey: $apiToken);

        $this->endpoint = '/Execute/AccessorialsList';
    }

    public function getAccessorialsList(): Response
    {
        $response = $this->makeRequest('GET', $this->endpoint);

        return $response;
    }
}
