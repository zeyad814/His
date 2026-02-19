<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFamilyPlanningFollowUpRequest extends FormRequest
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
            'visit_date' => 'sometimes|date',
            'get_method' => 'sometimes|boolean',
            'change_method' => 'sometimes|boolean',
            'follow_up_current_method' => 'sometimes|boolean',
            'medical_complications' => 'sometimes|boolean',
            'remove_iud' => 'sometimes|boolean',
            'remove_capsule' => 'sometimes|boolean',
            'reproductive_health' => 'sometimes|boolean',
            'counseling' => 'sometimes|boolean',

            'referral' => 'nullable|string|max:255',
            'treatment' => 'nullable|string|max:255',
            'dispensed_method' => 'nullable|string|max:100',
            'quantity' => 'nullable|integer|min:0',
            'next_visit_date' => 'nullable|date|after_or_equal:visit_date',
            'notes' => 'nullable|string',
        ];
    }
}
