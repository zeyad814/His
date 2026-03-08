<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class ReTestCriticalResultRequest extends FormRequest
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
            'second_result_value' => 'required|string|max:500',
            'second_result_generated_at' => 'required|date',
            'second_notified_at' => 'required|date|after_or_equal:second_result_generated_at',
            'second_recipient_id' => 'required|exists:doctors,id',
            'reporting_difficulties' => 'nullable|string|max:1000',
        ];
    }
}
