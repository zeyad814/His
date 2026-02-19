<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreFamilyPlanningFollowUpRequest extends FormRequest
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
            // التاريخ (إجباري ولازم يكون تاريخ صحيح)
            'visit_date' => 'required|date',

            // الـ Checkboxes (كلها Boolean: يقبل 0, 1, true, false)
            'get_method' => 'boolean',
            'change_method' => 'boolean',
            'follow_up_current_method' => 'boolean',
            'medical_complications' => 'boolean',
            'remove_iud' => 'boolean',
            'remove_capsule' => 'boolean',
            'reproductive_health' => 'boolean',
            'counseling' => 'boolean',

            // الحقول النصية (اختيارية Nullable)
            'referral' => 'nullable|string|max:255',
            'treatment' => 'nullable|string|max:255',
            'dispensed_method' => 'nullable|string|max:100',

            // الكمية (رقم صحيح ولا يقل عن صفر)
            'quantity' => 'nullable|integer|min:0',

            // موعد الزيارة القادمة (تاريخ ولازم يكون بعد تاريخ الزيارة الحالية)
            'next_visit_date' => 'nullable|date|after_or_equal:visit_date',

            'notes' => 'nullable|string',
        ];
    }
}
