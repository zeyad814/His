<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;

class StoreHealthUnitRequest extends FormRequest
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
            'health_administration_id' => 'required | exists:health_administrations,id',
            'name' => 'required | string | max:255',
            'code' => 'required | string | max:50 | unique:health_units,code',
            'address' => 'required | string | max:500',
            'city' => 'required | string | max:100',
            'email' => 'required | email | max:255 | unique:health_units,email',
            'phone' => ['required', 'string', 'max:20', 'unique:health_units,phone','regex:/^([0-9\s\-\+\(\)]*)$/'],
        ];
    }
}
