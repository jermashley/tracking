<?php

namespace App\Services\Pipeline;

class PipelineApiAccessorialsList extends PipelineApiBaseService
{
    protected $endpoint;

    public function __construct(string $apiToken)
    {
        parent::__construct(config('services.pipeline.base_url'), $apiToken);

        $this->endpoint = '/api/v1/Execute/AccessorialsList';
    }


    /**
     * @return bool
     * returns true if the request was successful, false otherwise
     * this will help us validate and check if api token is valid
     */
    public function getAccessorialsList(): bool {
        $response = $this->makeRequest('GET', $this->endpoint);

        return $response->successful();
    }

}
