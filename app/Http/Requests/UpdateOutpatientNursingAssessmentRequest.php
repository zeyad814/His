<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOutpatientNursingAssessmentRequest extends FormRequest
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
            // بيانات التقييم التمريضي - كلها Optional (sometimes) في التعديل
            'family_member_id'               => 'sometimes|exists:family_members,id',
            'weight'                         => 'sometimes|numeric',
            'height'                         => 'sometimes|numeric',
            'blood_pressure'                 => 'sometimes|string',
            'pulse'                          => 'sometimes|integer',
            'respiratory_rate'               => 'sometimes|integer',
            'temperature'                    => 'sometimes|numeric',
            'spo2'                           => 'nullable|integer',
            'is_smoking'                     => 'sometimes|boolean',
            'has_allergy'                    => 'sometimes|boolean',
            'allergy_details'                => 'required_if:has_allergy,true|nullable|string',
            'pain_score'                     => 'sometimes|integer|between:0,10',
            'pain_location'                  => 'required_if:pain_score,>0|nullable|string',
            'needs_detailed_fall_assessment' => 'sometimes|boolean',
            'nursing_notes'                  => 'nullable|string',

            // نوع المقياس (لو هيتعدل)
            'scale_type'                     => 'sometimes|nullable|in:morse,humpty_dumpty',

            // فالييشن Morse Scale (يتم التحقق منها فقط إذا كان النوع morse)
            'm_history_falling'              => 'sometimes|nullable|integer',
            'm_secondary_diagnosis'          => 'sometimes|nullable|integer',
            'm_ambulatory_aid'               => 'sometimes|nullable|integer',
            'm_iv_therapy'                   => 'sometimes|nullable|integer',
            'm_gait_transferring'            => 'sometimes|nullable|integer',
            'm_mental_status'                => 'sometimes|nullable|integer',

            // فالييشن Humpty Dumpty (يتم التحقق منها فقط إذا كان النوع humpty_dumpty)
            'h_age'                          => 'sometimes|nullable|integer',
            'h_gender'                       => 'sometimes|nullable|integer',
            'h_diagnosis'                    => 'sometimes|nullable|integer',
            'h_cognitive_impairments'        => 'sometimes|nullable|integer',
            'h_environmental_factors'        => 'sometimes|nullable|integer',
            'h_surgery_sedation_anesthesia'  => 'sometimes|nullable|integer',
            'h_medication_usage'             => 'sometimes|nullable|integer',
        ];
    }
}
