<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;

class StoreHealthAdministrationRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:health_administrations,name'],
            'address' => ['nullable', 'string', 'max:500'],
            'email' => ['nullable', 'email', 'max:255', 'unique:health_administrations,email'],
            'phone' => ['nullable', 'string', 'max:20', 'unique:health_administrations,phone','regex:/^([0-9\s\-\+\(\)]*)$/'] // اختيار اختياري للتأكد من صيغة الأرقام
        ];
    }
}
