<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\Pipeline\PipelineApiDocuments;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller
{
    public function shipmentDocuments(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'trackingNumber' => 'required|string',
            'companyId' => 'required|integer|exists:companies,pipeline_company_id',
        ]);

        $company = Company::whereId($validated['companyId'])->with('apiToken')->first();

        $shipmentDocumentsData = new PipelineApiDocuments(apiKey: $company->apiToken->api_token);

        $shipmentDocumentsResponse = $shipmentDocumentsData->getShipmentDocuments(
            $request->input('trackingNumber'),
            $company->apiToken->api_token
        );

        // If error in shipmentDocumentsResponse, redirect to error page.
        if ($shipmentDocumentsResponse->failed() || $shipmentDocumentsResponse->clientError()) {
            return response()->json([
                'error' => 'Shipment Files not found or invalid.',
            ], Response::HTTP_NOT_FOUND);
        }
        $documents = [];
        foreach ($shipmentDocumentsResponse->json() as $document) {
            if (! in_array($document['name'], ['bol', 'pod'])) {
                continue;
            }
            $documents[] = [
                'name' => strtoupper($document['name']),
                'url' => $document['file'],
                'size' => $this->getFileSize($document['file']),
            ];
        }

        return response()->json([
            'shipmentDocuments' => $documents,
        ], Response::HTTP_OK);
    }

    private function getFileSize(string $fileUrl): string
    {
        $headers = get_headers($fileUrl, 1);
        if (isset($headers['Content-Length'])) {
            return is_array($headers['Content-Length']) ? $headers['Content-Length'][array_key_last($headers['Content-Length'])] : $headers['Content-Length'];
        }

        return 'Unknown size';
    }
}
