<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:doctor',

            'national_id' => 'required|string|size:14|unique:doctors,national_id',
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:150',
            'license_number' => 'required|string|unique:doctors,license_number',
            'start_date' => 'required|date',

            // 'health_unit_id' => 'required|exists:health_units,id',
            // 'department_id' => 'required|exists:departments,id',
        ];
    }
}
