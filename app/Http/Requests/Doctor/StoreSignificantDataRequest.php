<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreSignificantDataRequest extends FormRequest
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
            "family_member_id" => "required|exists:family_members,id",
            'record_date' => 'required|date',
            'case_description' => 'required|string|min:5',
            "action_doctor_name" => "required|string|max:255",
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'family_member_id' => $this->route('family_member_id'),
        ]);
    }
}
