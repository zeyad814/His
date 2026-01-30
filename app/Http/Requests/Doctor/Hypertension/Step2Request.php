<?php

namespace App\Http\Requests\Doctor\Hypertension;

use Illuminate\Foundation\Http\FormRequest;

class Step2Request extends FormRequest
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
            "id" => "required|exists:hypertension_follow_ups,id",
            'risk_factors' => 'nullable|array',
            'risk_factors.smoking' => 'boolean',
            'risk_factors.physical_inactivity' => 'boolean',
            'risk_factors.obese' => 'boolean',
            'risk_factors.family_history' => 'boolean',
            'risk_factors.dyslipidemia' => 'boolean',
            // Complications Validation
            'complications_and_target_organ_affection' => 'nullable|array',
            'complications_and_target_organ_affection.lvh_hf' => 'boolean',
            'complications_and_target_organ_affection.angina_mi' => 'boolean',
            'complications_and_target_organ_affection.stroke_tia' => 'boolean',
            'complications_and_target_organ_affection.ckd' => 'boolean',
            'complications_and_target_organ_affection.retinopathy' => 'boolean',
        ];
    }
}
