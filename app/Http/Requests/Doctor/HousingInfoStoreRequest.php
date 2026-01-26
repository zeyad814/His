<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class HousingInfoStoreRequest extends FormRequest
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
            'family_id' => 'required|exists:families,id',
            'rooms_count' => 'required|integer|min:1',
            'sleeping_rooms_specified' => 'required|integer|min:1',
            'ventilation' => 'required|string',
            'water_source' => 'required|string',
            'sanitation_type' => 'required|string',
            'lighting_type' => 'required|string',
            'has_animals' => 'required|boolean',
            'barn_location' => 'nullable|required_if:has_animals,true|string',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'family_id' => $this->route('family_id'),
        ]);
    }
}
