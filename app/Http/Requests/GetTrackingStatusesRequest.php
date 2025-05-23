<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetTrackingStatusesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'trackingNumber' => 'required|string|max:255',
            'searchOption' => 'required|string|in:bol,carrierPro',
            'companyId' => 'integer',
            'zipCode' => 'string|max:10',
        ];
    }
}
