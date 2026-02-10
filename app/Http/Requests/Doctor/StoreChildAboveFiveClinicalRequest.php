<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreChildAboveFiveClinicalRequest extends FormRequest
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
            'visit_id' => [
                'required',
                'exists:visits,id',
                Rule::unique('child_above_five_clinicals', 'visit_id')->ignore($this->visit_id, 'visit_id') 
            ],
            'age' => 'required|string|max:50',
            'clinical_assessment' => 'nullable|string|max:1000',
            'nutritional_assessment' => 'nullable|string|max:1000',
            'psychiatric_screening' => 'nullable|string|max:1000',
            'school_achievement' => 'nullable|string|max:1000',
            'hb' => 'nullable|string|max:20',
            'urine' => 'nullable|string|max:100',
            'stool' => 'nullable|string|max:100',
            'other_investigations' => 'nullable|string|max:255',
            'health_ed_parents' => 'nullable|boolean',
            'health_ed_child' => 'nullable|boolean',
            'remarks' => 'nullable|string|max:500',
        ];
    }
}
