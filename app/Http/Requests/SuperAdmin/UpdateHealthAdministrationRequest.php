<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHealthAdministrationRequest extends FormRequest
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
            'name' => 'required | string | max:255 | unique:health_administrations,name,' . $id,
            'address' => 'required | string | max:500',
            'email' => 'required | email | max:255 | unique:health_administrations,email,' . $id,
            'phone' => ['required','string','max:20',"unique:health_administrations,phone,$id",'regex:/^([0-9\s\-\+\(\)]*)$/'],
        ];
    }
}
