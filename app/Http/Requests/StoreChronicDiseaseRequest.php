<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreChronicDiseaseRequest extends FormRequest
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
            'family_member_id' => 'required|exists:family_members,id',
        'diagnosis' => [
            'required', 'string', 'max:255',
            //  التشخيص ميتكررش لنفس الشخص
            Rule::unique('chronic_diseases')->where('family_member_id', $this->family_member_id)
        ],
        'date_diagnosed' => 'nullable|date',
        'risk_factors' => 'nullable|string',
        ];
    }
}
