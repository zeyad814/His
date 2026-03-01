<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhysiotherapyAssessmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'assessment_date' => $this->assessment_date ? $this->assessment_date->format('Y-m-d') : null,
            'case_info' => [
                'type' => $this->case_type,
                'occupation' => $this->occupation,
                'referral_source' => $this->referral_source,
            ],
            
            // التاريخ المرضي (Past History)
            'medical_history' => [
                'notes' => $this->medical_history_notes,
                'has_diabetes' => (bool)$this->has_diabetes,
                'has_hypertension' => (bool)$this->has_hypertension,
                'has_cardiac_disorder' => (bool)$this->has_cardiac_disorder,
                'has_renal_disorder' => (bool)$this->has_renal_disorder,
                'has_hepatic_disorder' => (bool)$this->has_hepatic_disorder,
            ],

            // الشكوى الحالية (Present History)
            'present_condition' => [
                'chief_complaint' => $this->chief_complaint,
                'present_since' => $this->present_since,
                'onset' => $this->onset,
                'course' => $this->course,
                'is_remittent' => (bool)$this->is_remittent,
                'pain_duration' => $this->pain_duration,
                'pain_status' => $this->pain_status,
            ],

            // الفحوصات (Investigations)
            'investigations' => [
                'x_ray' => (bool)$this->inv_x_ray,
                'ct' => (bool)$this->inv_ct,
                'mri' => (bool)$this->inv_mri,
                'emg' => (bool)$this->inv_emg,
                'lab' => (bool)$this->inv_lab,
                'details' => $this->investigation_details,
            ],

            // الفحص العام (Examination)
            'physical_examination' => [
                'gait' => $this->gait_assessment,
                'muscle_test' => $this->manual_muscle_test,
                'special_tests' => $this->special_tests,
                'neurological' => $this->neurological_examination,
            ],

            'diagnosis' => $this->diagnosis,

            // الأهداف (Goals)
            'treatment_goals' => [
                'relief_pain' => (bool)$this->goal_relief_pain,
                'reduce_swelling' => (bool)$this->goal_reduce_swelling,
                'improve_rom' => (bool)$this->goal_improve_rom,
                'improve_strength' => (bool)$this->goal_improve_strength,
                'improve_gait' => (bool)$this->goal_improve_gait,
                'other_goals' => $this->other_goals,
            ],

            // الخطة العلاجية (Treatment Plan)
            'treatment_plan' => [
                'modality_us' => (bool)$this->modality_us,
                'modality_ir' => (bool)$this->modality_ir,
                'modality_tens' => (bool)$this->modality_tens,
                'modality_faradic' => (bool)$this->modality_faradic,
                'modality_laser' => (bool)$this->modality_laser,
                'exercises' => $this->manual_therapy_exercises,
                'follow_up' => $this->follow_up_schedule,
            ],
            
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
