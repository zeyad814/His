<?php

namespace App\Http\Requests\Doctor\Hypertension;

use Illuminate\Foundation\Http\FormRequest;

class Step3Request extends FormRequest
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
            // تحاليل كل 6 أشهر
            'workup_6_month' => 'nullable|array',
            'workup_6_month.urine_analysis' => 'nullable|string|max:255',
            'workup_6_month.creatinine_egfr' => 'nullable|string|max:255',
            // التحاليل السنوية
            'workup_annual' => 'nullable|array',
            'workup_annual.total_cholesterol' => 'nullable|string|max:100',
            'workup_annual.cbc' => 'nullable|string|max:100',
            'workup_annual.fasting_sugar' => 'nullable|string|max:100',
            'workup_annual.k_na' => 'nullable|string|max:100', // Potassium & Sodium
            'workup_annual.ecg' => 'nullable|string|max:255',
            'workup_annual.tg' => 'nullable|string|max:100',    // Triglycerides
            'workup_annual.hdl' => 'nullable|string|max:100',
            'workup_annual.ldl' => 'nullable|string|max:100',
        ];
    }
}
