<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePremaritalScreeningRequest extends FormRequest
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
        'family_member_id'          => 'sometimes|exists:family_members,id',
        'consanguinity'             => 'sometimes|boolean',
        'hereditary_diseases'       => 'nullable|string|max:1000',
        'infectious_diseases'       => 'nullable|string|max:1000',
        'chronic_diseases'          => 'nullable|string|max:1000',
        'previous_surgeries'        => 'nullable|string|max:1000',
        
        'blood_pressure'            => 'nullable|string|max:20',
        'pulse'                     => 'nullable|integer|min:30|max:250',
        'weight'                    => 'nullable|numeric|min:1|max:500',
        'height'                    => 'nullable|numeric|min:30|max:300',
        'general_look'              => 'nullable|string|max:500',
        
        'blood_group_rh'            => 'nullable|string|max:10',
        'hemoglobin_level'          => 'nullable|string|max:50',
        'blood_sugar'               => 'nullable|string|max:50',
        
        'medical_recommendation'     => 'nullable|string|max:1000',
        'is_referred_to_specialist' => 'sometimes|boolean',
        'patient_informed'          => 'sometimes|boolean',
        'examination_date'          => 'sometimes|date|before_or_equal:today',
        ];
    }
}
