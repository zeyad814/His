<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class FamilyUpdateRequest extends FormRequest
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
        $familyId = $this->route('family_id');

        return [
            'family_id' => 'required|exists:families,id',
            'family_code' => 'required|unique:families,family_code,' . $familyId,
            'national_id' => 'required|digits:14|unique:families,national_id,' . $familyId,
            'head_name' => 'required|string|max:255',
            'governorate' => 'required|string',
            'health_department' => 'required|string',
            'health_unit' => 'required|string',
            'village_or_city' => 'required|string',
            'address' => 'required|string',
            'mobile_phone' => 'required|string',
            'work_phone' => 'nullable|string',
            'nearest_phone' => 'nullable|string',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'family_id' => $this->route('family_id'),
        ]);
    }
}
