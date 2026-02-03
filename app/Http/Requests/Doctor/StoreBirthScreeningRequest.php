<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreBirthScreeningRequest extends FormRequest
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
            'has_danger_signs' => 'boolean',
            'danger_signs_details' => 'nullable|string|max:500',
            'delivery_type' => 'nullable|string|max:255',
            'delivery_place' => 'nullable|string|max:255',
            'delivered_by' => 'nullable|string|max:255',
            'incubator_entry' => 'boolean',
            'incubator_reason_duration' => 'nullable|string',
            'breastfeeding_start' => 'nullable|string',
            'has_jaundice' => 'boolean',
            'jaundice_date' => 'nullable|date',
            'jaundice_action_treatment' => 'nullable|string',
            'first_sample_date' => 'nullable|date',
            'first_sample_result' => 'nullable|string',
            'repeated_sample_date' => 'nullable|date',
            'repeated_sample_result' => 'nullable|string',
            'venous_sample_date' => 'nullable|date',
            'final_screening_result' => 'nullable|string',
            'final_diagnosis' => 'nullable|string',
            'oae_test_result' => 'nullable|string',
            'vitamin_a_dose' => 'nullable|in:9_months,18_months',
        ];
    }
}
