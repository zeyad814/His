<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OutpatientNursingAssessmentResource extends JsonResource
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
            'patient_info' => [
                'name' => $this->familyMember->full_name,
                'gender' => $this->familyMember->is_male ? 'Male' : 'Female',
            ],

            'nurse_info' => [
                'id' => $this->nurse->id,
                'name' => $this->nurse->name ?? 'N/A',
            ],

            // العلامات الحيوية في مجموعة واحدة
            'vitals' => [
                'weight' => $this->weight,
                'height' => $this->height,
                'blood_pressure' => $this->blood_pressure,
                'pulse' => $this->pulse,
                'respiratory_rate' => $this->respiratory_rate,
                'temperature' => $this->temperature,
                'spo2' => $this->spo2,
            ],

            // التاريخ الطبي والحساسية
            'medical_assessment' => [
                'is_smoking' => $this->is_smoking,
                'is_alcoholic' => $this->is_alcoholic,
                'has_allergy' => $this->has_allergy,
                'allergy_details' => $this->allergy_details,
                'pain_score' => $this->pain_score,
                'pain_location' => $this->pain_location,
            ],

            // الجزء "الذهبي": دمج تقييم السقوط لو موجود
            'fall_risk' => [
                'needs_assessment' => $this->needs_detailed_fall_assessment,
                'risk_level' => $this->final_fall_risk_level,
                // هنا بنعرض بيانات الجدول التاني لو موجودة
                'details' => $this->whenLoaded('fallAssessment', function () {
                    return [
                        'type' => $this->fallAssessment->scale_type,
                        'total_score' => $this->fallAssessment->total_score,
                        'raw_scores' => $this->fallAssessment->scale_type === 'morse'
                            ? $this->getMorseScores()
                            : $this->getHumptyScores(),
                    ];
                }),
            ],

            'notes' => $this->nursing_notes,
            'created_at' => $this->created_at->format('Y-m-d H:i'),
        ];
    }

    // دوال مساعدة لترتيب الـ JSON
    private function getMorseScores()
    {
        return [
            'history_falling' => $this->fallAssessment->m_history_falling,
            'secondary_diagnosis' => $this->fallAssessment->m_secondary_diagnosis,
            'ambulatory_aid' => $this->fallAssessment->m_ambulatory_aid,
            'iv_therapy' => $this->fallAssessment->m_iv_therapy,
            'gait' => $this->fallAssessment->m_gait_transferring,
            'mental_status' => $this->fallAssessment->m_mental_status,
        ];
    }

    private function getHumptyScores()
    {
        return [
            'age' => $this->fallAssessment->h_age,
            'gender' => $this->fallAssessment->h_gender,
            'diagnosis' => $this->fallAssessment->h_diagnosis,
            'cognitive' => $this->fallAssessment->h_cognitive_impairment,
            'environmental' => $this->fallAssessment->h_environmental_factors,
            'surgery' => $this->fallAssessment->h_surgery_sedation,
            'medication' => $this->fallAssessment->h_medication_usage,
        ];
    }
}
