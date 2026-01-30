<?php

namespace App\Http\Requests\Doctor\Hypertension;

use Illuminate\Foundation\Http\FormRequest;

class Step4Request extends FormRequest
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
            // الخطة العلاجية (نص طويل)
            'treatment_plan' => 'nullable|string|max:1000',
            // التثقيف الصحي (JSON)
            'health_education' => 'nullable|array',
            'health_education.diet_weight_loss' => 'boolean',
            'health_education.physical_activity' => 'boolean',
            'health_education.low_salt' => 'boolean',
            'health_education.quitting_smoking' => 'boolean',
        ];
    }
}
