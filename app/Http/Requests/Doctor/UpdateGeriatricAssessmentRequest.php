<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGeriatricAssessmentRequest extends FormRequest
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
            'family_member_id'       => 'sometimes|required|exists:family_members,id',
            'overall_status'         => 'nullable|string|max:255',
            'doctor_recommendations' => 'nullable|string',

            // مصفوفة الإجابات للتحديث
            'answers'                => 'required|array|min:1',
            'answers.*.question_id'  => 'required|exists:assessment_questions,id',
            'answers.*.answer_value' => 'present',
        ];
    }
}
