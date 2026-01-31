<?php

namespace App\Http\Requests\Doctor\Diabetes;

use Illuminate\Foundation\Http\FormRequest;

class StoreStep3Request extends FormRequest
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
            // Every Visit
            'workup_every_visit' => 'nullable|array',
            'workup_every_visit.fbs' => 'nullable|string',
            'workup_every_visit.urine_analysis' => 'nullable|string',
            // 6 Months
            'workup_6_month' => 'nullable|array',
            'workup_6_month.hba1c' => 'nullable|string',
            'workup_6_month.creatinine_egfr' => 'nullable|string',
            // Annual
            'workup_annual' => 'nullable|array',
            'workup_annual.total_cholesterol' => 'nullable|string',
            'workup_annual.fundus_examination' => 'nullable|string',
            'workup_annual.foot_examination' => 'nullable|string',
            'workup_annual.ecg' => 'nullable|string',
            'workup_annual.urinary_micr' => 'nullable|string',
            'workup_annual.ldl' => 'nullable|string',
            'workup_annual.hdl' => 'nullable|string',
            'workup_annual.tg' => 'nullable|string',
        ];
    }
}
