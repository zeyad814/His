<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
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
            'referral_id' => 'required|exists:referrals,id',
            
            // التواريخ
            'arrival_at' => 'nullable|date_format:Y-m-d H:i:s', // يجب أن يكون بصيغة تاريخ ووقت
            'revisit_date' => 'nullable|date|after_or_equal:today', // تاريخ المراجعة لازم يكون مستقبلي
            
            // النتائج والتشخيص
            'specialist_findings' => 'nullable|string|min:5',
            'hospital_investigations' => 'nullable|string',
            'final_diagnosis' => 'nullable|string',
            'current_medications' => 'nullable|string',
            
            // التدخلات (Interventions)
            'admission_ward' => 'nullable|string|max:50',
            'surgery_type' => 'nullable|string|max:255',
            'other_interventions' => 'nullable|string',
            
            // التوصيات والإجازات
            'recommendations' => 'nullable|string',
            'sick_leave_days' => 'nullable|integer|min:0|max:365', // مدة منطقية للإجازة
            'follow_up_instructions' => 'nullable|string',
        ];
    }
}
