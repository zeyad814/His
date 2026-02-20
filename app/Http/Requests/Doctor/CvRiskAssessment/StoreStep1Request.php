<?php

namespace App\Http\Requests\Doctor\CvRiskAssessment;

use Illuminate\Foundation\Http\FormRequest;

class StoreStep1Request extends FormRequest
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
            'assessment_date' => 'required|date',
            'hypertension' => 'boolean',
            'dm' => 'boolean',
            'obesity' => 'boolean',
            'smoking' => 'boolean',
            'family_history_cardiac' => 'boolean',
        ];
    }
}
