<?php

namespace App\Http\Requests\Doctor\Hypertension;

use Illuminate\Foundation\Http\FormRequest;

class Step1Request extends FormRequest
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
            'date' => 'required|date',
            'chief_complaint' => 'nullable|string',
            'bp' => 'required|array',
            'bp.systolic' => 'required|integer|min:40|max:300',
            'bp.diastolic' => 'required|integer|min:30|max:200',
        ];
    }
}
