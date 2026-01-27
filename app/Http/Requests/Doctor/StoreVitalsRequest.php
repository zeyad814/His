<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreVitalsRequest extends FormRequest
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
            'physical_examination_id' => 'required|exists:physical_examinations,id',
            'blood_pressure' => 'nullable|string',
            'pulse' => 'nullable|integer',
            'temperature' => 'nullable|numeric',
            'respiratory_rate' => 'nullable|integer',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'bmi' => 'nullable|numeric',
            'general_appearance' => 'nullable|string',
            'pain_assessment' => 'nullable|string',
            'lab_results' => 'nullable|array',
            'lab_results.*' => 'nullable|string',
        ];
    }
}
