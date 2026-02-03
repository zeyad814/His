<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClinicalExaminationRequest extends FormRequest
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
            'visit_date' => 'required|date',
            'age_stage' => 'required|in:under_2_months,2,4,6,9,12,18,24,36,48,60',
            'clinical_assessment' => 'nullable|string|min:5|max:1000',
            'parental_concern' => 'nullable|string|max:1000',
            'health_education' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
