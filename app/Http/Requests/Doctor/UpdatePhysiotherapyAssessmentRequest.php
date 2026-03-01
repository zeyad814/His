<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhysiotherapyAssessmentRequest extends FormRequest
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
            'assessment_date' => 'sometimes|date',
            'case_type' => 'sometimes|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'referral_source' => 'nullable|string|max:255',

            // التاريخ المرضي
            'medical_history_notes' => 'nullable|string',
            'has_diabetes' => 'boolean',
            'has_hypertension' => 'boolean',
            'has_cardiac_disorder' => 'boolean',
            'has_renal_disorder' => 'boolean',
            'has_hepatic_disorder' => 'boolean',

            // التاريخ الحالي
            'chief_complaint' => 'sometimes|string',
            'present_since' => 'nullable|string',
            'onset' => 'nullable|in:acute,gradual',
            'course' => 'nullable|in:progressive,regressive,intermittent',
            'is_remittent' => 'boolean',
            'pain_duration' => 'nullable|string',
            'pain_status' => 'nullable|in:worsening,unchanging,improving',

            // الفحوصات
            'inv_x_ray' => 'boolean',
            'inv_ct' => 'boolean',
            'inv_mri' => 'boolean',
            'inv_emg' => 'boolean',
            'inv_lab' => 'boolean',
            'investigation_details' => 'nullable|string',

            // الفحص العام (General Examination)
            'gait_assessment' => 'nullable|string',
            'manual_muscle_test' => 'nullable|string',
            'special_tests' => 'nullable|string',
            'neurological_examination' => 'nullable|string',

            // التشخيص والأهداف
            'diagnosis' => 'sometimes|string',
            'goal_relief_pain' => 'boolean',
            'goal_reduce_swelling' => 'boolean',
            'goal_improve_rom' => 'boolean',
            'goal_improve_strength' => 'boolean',
            'goal_improve_gait' => 'boolean',
            'other_goals' => 'nullable|string',

            // البرنامج العلاجي
            'modality_us' => 'boolean',
            'modality_ir' => 'boolean',
            'modality_tens' => 'boolean',
            'modality_faradic' => 'boolean',
            'modality_laser' => 'boolean',
            'manual_therapy_exercises' => 'nullable|string',
            'follow_up_schedule' => 'nullable|string',
        ];
    }
}
