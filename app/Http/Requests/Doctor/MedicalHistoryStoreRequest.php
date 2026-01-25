<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class MedicalHistoryStoreRequest extends FormRequest
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
            'medical_histories' => 'nullable|array',
            'medical_histories.*.family_member_id' => 'required|exists:family_members,id',
            'medical_histories.*.discovery_date' => 'nullable|date|before_or_equal:today',
            'medical_histories.*.disease_type' => 'nullable|string',
            'medical_histories.*.type_of_illness' => 'nullable|string',
            'medical_histories.*.note' => 'nullable|string',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'family_id' => $this->route('family_id'),
        ]);
    }
}
