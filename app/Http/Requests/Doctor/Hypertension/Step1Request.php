<?php

namespace App\Http\Requests\Doctor\Hypertension;

use Illuminate\Foundation\Http\FormRequest;

class Step1Request extends FormRequest
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
            "visit_id" => 'required|exists:visits,id|unique:hypertension_follow_ups,visit_id',
            'date' => 'required|date',
            'chief_complaint' => 'nullable|string',
            // 'bp' => 'required|array',
            'bp_systolic' => 'required|integer|min:40|max:300',
            'bp_diastolic' => 'required|integer|min:30|max:200',
        ];
    }

    public function messages(): array
    {
        return [
            // الرسالة المناسبة لـ unique visit_id
            'visit_id.unique' => 'A hypertension follow-up record already exists for this visit. Duplicate entries are not allowed.',

            'visit_id.required' => 'The visit ID is required to link this follow-up.',
            'visit_id.exists' => 'The selected visit ID is invalid or does not exist.',

            'bp.required' => 'Blood pressure readings (systolic and diastolic) are mandatory.',
        ];
    }
}
