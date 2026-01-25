<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class AssignDoctorsToFamilyRequest extends FormRequest
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
            'family_doctor_id' => 'required|exists:doctors,id',
            'family_doctor_date' => 'required|date|after_or_equal:today',
            'dentist_id' => 'required|exists:doctors,id',
            'dentist_date' => 'required|date|after_or_equal:today',
        ];
    }
}
