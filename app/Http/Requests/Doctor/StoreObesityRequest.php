<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreObesityRequest extends FormRequest
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
                Rule::unique('obesity_records', 'visit_id')->ignore($this->visit_id, 'visit_id') 
            ],
            'visit_date' => 'required|date',
            'visit_type' => 'required|in:first_visit,follow_up',
            'weight' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:30',
            'nutrition_counseling' => 'boolean',
            'dietary_plan' => 'boolean',
            'referral' => 'boolean',
        ];
    }
}
