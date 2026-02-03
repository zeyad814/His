<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpecialCasesRequest extends FormRequest
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
            'sensory_defects' => 'boolean',
            'speech_difficulties' => 'boolean',
            'growth_retardation' => 'boolean',
            'autism' => 'boolean',
            'genetic_diseases' => 'boolean',
            'allergies' => 'boolean',
            'other_special_cases' => 'nullable|string',
            'special_cases_medications' => 'nullable|string',
        ];
    }
}
