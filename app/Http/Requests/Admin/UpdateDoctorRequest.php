<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDoctorRequest extends FormRequest
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
        $doctorId = $this->route('id');

        return [
            'name' => 'required|string|max:255',
            
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
                    ->ignore($doctorId, 'userable_id')
                    ->where('userable_type', \App\Models\Doctor::class)
            ],

            'national_id' => [
                'required',
                'string',
                'size:14',
                Rule::unique('doctors', 'national_id')->ignore($doctorId)
            ],

            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:150',
            
            'license_number' => [
                'required',
                'string',
                Rule::unique('doctors', 'license_number')->ignore($doctorId)
            ],

            'start_date' => 'required|date',
        ];
    }
}
