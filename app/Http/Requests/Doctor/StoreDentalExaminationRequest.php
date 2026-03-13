<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreDentalExaminationRequest extends FormRequest
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
            'family_member_id' => 'required|exists:family_members,id|unique:dental_examinations,family_member_id',
            'occupation' => 'nullable|string|max:255',
            'location_type' => 'required|in:1,2',
            'extra_oral_exam' => 'required|integer|between:0,9',
            'tmj_symptom' => 'required|in:0,1,9',
            'tmj_signs' => 'required|in:0,1,9',
            'tmj_clicking' => 'required|boolean',
            'tmj_tenderness' => 'required|boolean',
            'tmj_reduced_mobility' => 'required|boolean',
            'mucosa_condition' => 'required|integer|between:0,9',
            'mucosa_location' => 'required|integer|between:0,9',
            'mucosa_other' => 'nullable|string|max:500',
            'cpi_sections' => 'required|array|size:6',
            'cpi_sections.*' => 'required|string|max:1',
            'fluorosis_index' => 'required|integer|between:0,9',
            'trauma_index' => 'required|integer|between:0,5',
            'white_spot_lesions' => 'nullable|string',
            'enamel_defects' => 'nullable|string',
            'developmental_anomalies' => 'nullable|string',
            'clefts' => 'nullable|string',
            'occlusion_class' => 'nullable|integer|between:1,4',
            'primary_mesial_step' => 'nullable|integer|between:1,3',
            'tooth_statuses' => 'required|array|min:1',
            'tooth_statuses.*.tooth_number' => 'required|integer',
            'tooth_statuses.*.crown_status' => 'required|integer|between:0,9',
            'tooth_statuses.*.root_status' => 'required|integer|between:0,9',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'family_member_id.unique' => 'This patient already has an existing dental examination record.',
            'family_member_id.required' => 'The patient field is required.',
            'family_member_id.exists' => 'The selected patient does not exist.',
        ];
    }
}
