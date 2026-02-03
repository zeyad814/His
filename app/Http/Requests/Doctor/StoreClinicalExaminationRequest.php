<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicalExaminationRequest extends FormRequest
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
            'family_member_id' => 'required|exists:family_members,id',
            'visit_id' => 'required|exists:visits,id',
            'visit_date' => 'required|date',
            'age_stage' => 'required|in:under_2_months,2,4,6,9,12,18,24,36,48,60',
            'clinical_assessment' => 'nullable|string',
            'parental_concern' => 'nullable|string',
            'health_education' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }
}
