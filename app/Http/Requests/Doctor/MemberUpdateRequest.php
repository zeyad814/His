<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class MemberUpdateRequest extends FormRequest
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
            "family_id" => "required|exists:families,id",
            'members' => 'required|array|min:1',
            'members.*.id' => 'required|exists:family_members,id',
            'members.*.full_name' => 'required|string|max:255',
            'members.*.is_male' => 'required|boolean',
            'members.*.birth_date' => 'required|date',
            'members.*.relationship_to_head' => 'required|string',
            'members.*.insurance_type' => 'nullable|string',
            'members.*.notes' => 'nullable|string',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'family_id' => $this->route('family_id'),
        ]);
    }
}
