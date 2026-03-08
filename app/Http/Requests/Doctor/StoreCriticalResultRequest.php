<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreCriticalResultRequest extends FormRequest
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
            'visit_id' => 'required|exists:visits,id|unique:critical_results,visit_id',
            'test_type_and_value' => 'required|string',
            'result_generated_at' => 'required|date',
            'notified_at' => 'nullable|date|after_or_equal:result_generated_at',
            'notification_method' => 'nullable|string|in:telephone,face_to_face',
            'receiving_clinic' => 'required|string|max:150',
            'recipient_id' => 'required|exists:doctors,id',
            // 'doctor_action' => 'nullable|string|min:5',
        ];
    }
}
