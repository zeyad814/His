<?php

namespace App\Http\Requests\Doctor\Hypertension;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStep1Request extends FormRequest
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
            "id" => "required|exists:hypertension_follow_ups,id",
            'date' => 'required|date',
            'chief_complaint' => 'nullable|string',
            'bp' => 'required|array',
            'bp.systolic' => 'required|integer|min:40|max:300',
            'bp.diastolic' => 'required|integer|min:30|max:200',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }
}
