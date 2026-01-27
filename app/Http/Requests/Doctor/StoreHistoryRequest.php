<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreHistoryRequest extends FormRequest
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
            'family_member_id' => 'required|integer|exists:family_members,id',
            'family_history' => 'nullable|string',
            'hospitalization' => 'nullable|string',
            'lab_tests_results' => 'nullable|string',
            'special_habits' => 'nullable|string',
            'previous_operations' => 'nullable|string',
            'current_medication' => 'nullable|string',
            'trauma_injuries' => 'nullable|string',
            'allergy' => 'nullable|string',
            'adverse_drug_reaction' => 'nullable|string',
            'abuse_negligence' => 'nullable|string',
            'psychiatric_history' => 'nullable|string',
        ];
    }
}
