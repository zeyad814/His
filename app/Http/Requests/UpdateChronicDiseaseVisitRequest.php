<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChronicDiseaseVisitRequest extends FormRequest
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
            'complain' => 'nullable|string',
            'exam' => 'nullable|string',
            'vital_signs' => 'nullable|string',
            'investigations' => 'nullable|string',
            'management' => 'nullable|string',
            'visit_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ];
    }
}
