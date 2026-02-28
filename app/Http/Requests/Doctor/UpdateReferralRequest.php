<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReferralRequest extends FormRequest
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
        $referralId = $this->route('id');
        return [
            'referral_number' => 'sometimes|required|string|unique:referrals,referral_number,' . $referralId,
            'referred_to_entity' => 'nullable|string|max:255',
            'specialty' => 'nullable|string|max:150',
            'urgency_type' => 'sometimes|required|in:emergency,urgent,non_urgent',
            'bp' => ['nullable', 'string', 'regex:/^\d{2,3}\/\d{2,3}$/'],
            'pulse' => 'nullable|integer|between:30,250',
            'temp' => 'nullable|numeric|between:30,45',
            'rr' => 'nullable|integer|between:10,60',
            'reason_for_referral' => 'nullable|string',
            'relevant_history' => 'nullable|string',
            'exam_findings' => 'nullable|string',
            'relevant_investigations' => 'nullable|string',
            'provisional_diagnosis' => 'nullable|string',
        ];
    }
}
