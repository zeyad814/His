<?php

namespace App\Http\Requests\Doctor\Diabetes;

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
            'visit_id' => 'required|exists:visits,id|unique:diabetes_follow_ups,visit_id',
            'date' => 'required|date',
            'chief_complaint' => 'nullable|string',
        ];
    }

    /**
     * Customize validation error messages
     */
    public function messages(): array
    {
        return [
            'visit_id.required' => 'The follow-up record must be linked to a specific visit.',
            'visit_id.unique' => 'A diabetes follow-up has already been recorded for this visit; duplicates are not allowed.',
            'family_member_id.required' => 'The patient selection is required.',
            'date.required' => 'The follow-up date is mandatory.',
            // Optional: Adding a message for the date format if you have a date rule
            'date.date' => 'Please provide a valid date format.',
        ];
    }
}
