<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSignificantDataRequest extends FormRequest
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
            // "id" => "required|exists:significant_data,id",
            'record_date' => 'required|date',
            'case_description' => 'required|string|min:5',
            'action_doctor_name' => 'required|string|max:255',
        ];
    }

    // protected function prepareForValidation()
    // {
    //     $this->merge([
    //         'id' => $this->route('id'),
    //     ]);
    // }
}
