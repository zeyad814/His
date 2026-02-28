<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeedbackRequest extends FormRequest
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
            'referral_id' => 'sometimes|required|exists:referrals,id',
            
            // التواريخ
            'arrival_at' => 'sometimes|nullable|date_format:Y-m-d H:i:s',
            'revisit_date' => 'sometimes|nullable|date|after_or_equal:today',
            
            // البيانات الطبية
            'specialist_findings' => 'sometimes|nullable|string|min:5',
            'hospital_investigations' => 'sometimes|nullable|string',
            'final_diagnosis' => 'sometimes|nullable|string',
            'current_medications' => 'sometimes|nullable|string',
            
            // التدخلات
            'admission_ward' => 'sometimes|nullable|string|max:50',
            'surgery_type' => 'sometimes|nullable|string|max:255',
            'other_interventions' => 'sometimes|nullable|string',
            
            // التوصيات
            'recommendations' => 'sometimes|nullable|string',
            'sick_leave_days' => 'sometimes|nullable|integer|min:0|max:365',
            'follow_up_instructions' => 'sometimes|nullable|string',
        ];
    }
}
