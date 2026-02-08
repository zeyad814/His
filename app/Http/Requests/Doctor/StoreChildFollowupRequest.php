<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreChildFollowupRequest extends FormRequest
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
                Rule::unique('child_followups', 'visit_id')->ignore($this->visit_id, 'visit_id') 
            ],
            // 'visit_id' => 'required|exists:visits,id|unique:child_followups,visit_id',
            'age' => 'required|string',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
            'vaccine_dt' => 'required|boolean',
            'vaccine_meningitis' => 'required|boolean',
            'other_vaccines' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }
}
