<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class SocialResearchStoreRequest extends FormRequest
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
            'income_type' => 'required|in:fixed,variable',
            'avg_income' => 'required|numeric|min:0',
            'has_chronic_diseases' => 'required|boolean',
            'has_disability' => 'required|boolean',
            'receives_pension' => 'required|boolean',
            'eligible_for_free_service' => 'required|boolean',
            'supporter_name_on_death' => 'nullable|string|max:255',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'family_id' => $this->route('family_id'),
        ]);
    }
}
