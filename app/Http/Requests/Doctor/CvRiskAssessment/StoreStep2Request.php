<?php

namespace App\Http\Requests\Doctor\CvRiskAssessment;

use Illuminate\Foundation\Http\FormRequest;

class StoreStep2Request extends FormRequest
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
            'bp' => 'nullable|string|max:10',
            'height' => 'nullable|numeric|between:30,250',
            'weight' => 'nullable|numeric|between:2,300',
            'cholesterol_total' => 'nullable|numeric',
            'ldl_level' => 'nullable|numeric',
        ];
    }
}
