<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateChronicDiseaseRequest extends FormRequest
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
            'diagnosis' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('chronic_diseases')
                    ->where('family_member_id', $this->chronic_disease->family_member_id)
                    ->ignore($this->chronic_disease->id)
            ],
            'date_diagnosed' => 'sometimes|nullable|date',
            'risk_factors' => 'sometimes|nullable|string',

        ];
    }
}
