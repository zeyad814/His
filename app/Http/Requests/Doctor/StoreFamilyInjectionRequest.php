<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreFamilyInjectionRequest extends FormRequest
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
            'procedure_name'   => 'required|string|max:150',
            'phone'            => 'nullable|string|max:20',
            'is_agreed'        => 'required|boolean|accepted', 
            'visit_date'       => 'required|date|after_or_equal:today', 
            'visit_time'       => 'required',
        ];
    }
}
