<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StorePsychologicalSupportVisitRequest extends FormRequest
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
            'visit_date' => 'required|date',
            'questionnaire_type' => 'nullable|string',
            'visit_reason' => 'required|string',
            'questionnaire_result' => 'required|string',
            'initial_diagnosis' => 'required|string',
            'treatment_plan' => 'required|string',
            'referral_location' => 'nullable|string',
        ];
    }
}
