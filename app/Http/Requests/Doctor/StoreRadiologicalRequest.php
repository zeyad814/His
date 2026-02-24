<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreRadiologicalRequest extends FormRequest
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
            'required_xray' => 'required|in:أشعة عادية,سونار',
            'body_part' => 'required|string|max:100',
            'diagnoses_reason' => 'required|string',
            'priority' => 'required|in:عادي,مستعجل',
        ];
    }
}
