<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateThemeRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'primary.hue' => 'required|integer|min:0|max:360',
            'primary.saturation' => 'required|integer|min:0|max:100',
            'primary.brightness' => 'required|integer|min:0|max:100',
            'accent.hue' => 'required|integer|min:0|max:360',
            'accent.saturation' => 'required|integer|min:0|max:100',
            'accent.brightness' => 'required|integer|min:0|max:100',
            'deriveFrom' => 'required|string|in:primary,accent',
            'radius' => 'nullable|string|max:255',
            'is_system' => 'boolean',
        ];
    }
}
