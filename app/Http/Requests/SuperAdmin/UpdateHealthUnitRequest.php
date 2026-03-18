<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHealthUnitRequest extends FormRequest
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
        $id = $this->route('id');

        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:health_units,code,' . $id,
            'address' => 'nullable|string|max:500',
            'city' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => ['nullable', 'string', 'max:20', 'unique:health_units,phone,' . $id,'regex:/^([0-9\s\-\+\(\)]*)$/'],
        ];
    }
}
