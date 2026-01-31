<?php

namespace App\Http\Requests\Doctor\Diabetes;

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
            "id" => "required|exists:diabetes_follow_ups,id",
            'risk_factors' => 'nullable|array',
            'risk_factors.smoking' => 'boolean',
            'risk_factors.physical_inactivity' => 'boolean',
            'risk_factors.bmi' => 'boolean',
            'risk_factors.dyslipidemia' => 'boolean',
            'risk_factors.family_history' => 'boolean',

            // Complications (Checkboxes)
            'complications' => 'nullable|array',
            'complications.ckd' => 'boolean', // Chronic Kidney Disease
            'complications.neuropathy' => 'boolean',
            'complications.retinopathy' => 'boolean',
            'complications.diabetic_foot' => 'boolean',
            'complications.dka_hypoglycemia' => 'boolean',
        ];
    }
}
