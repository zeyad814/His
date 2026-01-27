<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreFinalAssessmentRequest extends FormRequest
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
            'physical_examination_id' => 'required|exists:physical_examinations,id',

            // حقول الـ JSON (تقبل مصفوفة)
            'eyes' => 'nullable|array',
            'ent' => 'nullable|array',
            'risk_factors' => 'nullable|array',

            // حقول الـ Text (تقبل نصوص)
            'nutritional_assessment' => 'nullable|string',
            'general_appearance' => 'nullable|string',
            'conclusion' => 'required|string',
        ];
    }
}
