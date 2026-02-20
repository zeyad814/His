<?php

namespace App\Http\Requests\Doctor\CvRiskAssessment;

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
            'cv_risk_level' => 'nullable|string|in:Low,Moderate,High',
            'management_plan' => 'nullable|string',
            'referral_to' => 'nullable|string|max:255',
            'follow_up_date' => 'nullable|date|after_or_equal:today',
        ];
    }
}
