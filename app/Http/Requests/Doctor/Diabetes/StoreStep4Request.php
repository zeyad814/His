<?php

namespace App\Http\Requests\Doctor\Diabetes;

use Illuminate\Foundation\Http\FormRequest;

class StoreStep4Request extends FormRequest
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
            // Health Education (Checkboxes - Boolean)
            'health_education' => 'nullable|array',
            'health_education.diet_weight_loss' => 'boolean',
            'health_education.physical_activity' => 'boolean',
            'health_education.smbg_hypoglycemia' => 'boolean',
            'health_education.quitting_smoking' => 'boolean',
            // Text Fields
            'referrals' => 'nullable|string',
            'treatment_plan' => 'nullable|string',
        ];
    }
}
