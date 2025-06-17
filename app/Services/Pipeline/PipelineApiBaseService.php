<?php

namespace App\Services\Pipeline;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class PipelineApiBaseService
{
    protected $baseUrl;

    protected $apiKey;

    protected $headers;

    public function __construct($urlOverride = null)
    {
        $this->baseUrl = $urlOverride ?? config('services.pipeline.api_url');
        $this->apiKey = config('services.pipeline.api_key');

        $this->headers = [
            'apiKey' => $this->apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

    }

    public function makeRequest(string $method, string $endpoint, array $data = []): Response
    {
        return Http::withHeaders($this->headers)
            ->$method($this->baseUrl.$endpoint, $data);
    }
}
