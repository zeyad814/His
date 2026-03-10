<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOutpatientNursingAssessmentRequest extends FormRequest
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
            // بيانات التقييم التمريضي الأساسية
            'family_member_id'               => 'required|exists:family_members,id',
            'weight'                         => 'required|numeric',
            'height'                         => 'required|numeric',
            'blood_pressure'                 => 'required|string',
            'pulse'                          => 'required|integer',
            'respiratory_rate'               => 'required|integer',
            'temperature'                    => 'required|numeric',
            'spo2'                           => 'nullable|integer',
            'is_smoking'                     => 'required|boolean',
            'has_allergy'                    => 'required|boolean',
            'allergy_details'                => 'required_if:has_allergy,true|nullable|string',
            'pain_score'                     => 'required|integer|between:0,10',
            'pain_location'                  => 'required_if:pain_score,>0|nullable|string',
            'needs_detailed_fall_assessment' => 'required|boolean',

            // نوع المقياس (إجباري لو فيه تقييم سقوط)
            'scale_type'                     => 'required_if:needs_detailed_fall_assessment,true|nullable|in:morse,humpty_dumpty',

            // فالييشن Morse Scale (إجباري لو النوع morse)
            'm_history_falling'              => 'required_if:scale_type,morse|nullable|integer',
            'm_secondary_diagnosis'          => 'required_if:scale_type,morse|nullable|integer',
            'm_ambulatory_aid'               => 'required_if:scale_type,morse|nullable|integer',
            'm_iv_therapy'                   => 'required_if:scale_type,morse|nullable|integer',
            'm_gait_transferring'            => 'required_if:scale_type,morse|nullable|integer',
            'm_mental_status'                => 'required_if:scale_type,morse|nullable|integer',

            // فالييشن Humpty Dumpty (إجباري لو النوع humpty_dumpty)
            'h_age'                          => 'required_if:scale_type,humpty_dumpty|nullable|integer',
            'h_gender'                       => 'required_if:scale_type,humpty_dumpty|nullable|integer',
            'h_diagnosis'                    => 'required_if:scale_type,humpty_dumpty|nullable|integer',
            'h_cognitive_impairments'        => 'required_if:scale_type,humpty_dumpty|nullable|integer',
            'h_environmental_factors'        => 'required_if:scale_type,humpty_dumpty|nullable|integer',
            'h_surgery_sedation_anesthesia'  => 'required_if:scale_type,humpty_dumpty|nullable|integer',
            'h_medication_usage'             => 'required_if:scale_type,humpty_dumpty|nullable|integer',
        ];
    }
}
