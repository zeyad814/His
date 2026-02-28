<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreReferralRequest extends FormRequest
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
            'referral_number' => 'required|string|unique:referrals,referral_number',
            'referred_to_entity' => 'nullable|string|max:255',
            'specialty' => 'nullable|string|max:150',
            'transport_method' => 'nullable|string|max:100', // أو ممكن تخليها in:ambulance,self
            
            'reason_for_referral' => 'nullable|string|min:5',
            'urgency_type' => 'required|in:emergency,urgent,non_urgent',
            
            // العلامات الحيوية (Vital Signs)
            'bp' => ['nullable', 'string', 'regex:/^\d{2,3}\/\d{2,3}$/'], // بيتحقق من فورمات الضغط زي 120/80
            'pulse' => 'nullable|integer|between:30,250',
            'temp' => 'nullable|numeric|between:30,45',
            'rr' => 'nullable|integer|between:10,60',
            
            // النصوص الطويلة
            'relevant_history' => 'nullable|string',
            'exam_findings' => 'nullable|string',
            'relevant_investigations' => 'nullable|string',
            'provisional_diagnosis' => 'nullable|string',
        ];
    }
}
