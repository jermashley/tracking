<?php

namespace App\Http\Requests;

use App\Rules\ValidCompanyBooleanField;
use Illuminate\Foundation\Http\FormRequest;

class ToggleCompanyOptionRequest extends FormRequest
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
            'field' => ['required', 'string', new ValidCompanyBooleanField],
        ];
    }
}
