<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PregnancyVisitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,

            // بيانات الربط (الأسماء بدل الـ IDs)
            'patient_name'     => $this->pregnancy && $this->pregnancy->familyMember
                ? $this->pregnancy->familyMember->full_name
                : 'غير مسجل',

            'doctor_name'      => $this->doctor ? $this->doctor->name : 'غير مسجل',

            'main_visit_info' => [
                'visit_id'   => $this->visit_id,
                'visit_type' => $this->visit ? $this->visit->visit_type : 'غير محدد',
                // لو جدول الزيارات فيه حقل اسمه visit_type أو status
            ],

            // التواريخ
            'visit_date'       => $this->visit_date,
            'next_visit'       => $this->next_visit,

            // الفحص العام (Vitals)
            'vitals'           => [
                'weight'         => $this->weight,
                'blood_pressure' => $this->blood_pressure,
                'general_exam'   => $this->general_exam,
            ],

            // التقييم التوليدي (Obstetric Assessment)
            'obstetric_assessment' => [
                'fundal_height'     => $this->fundal_height,
                'fetal_lie'         => $this->fetal_lie,
                'fetal_heart_rate'  => $this->fetal_heart_rate,
                'fetal_movement'    => $this->fetal_movement,
                'ultrasound_notes'  => $this->ultrasound,
            ],

            // التحاليل (Labs)
            'laboratory_results' => [
                'urine_analysis' => $this->urine_analysis,
                'hemoglobin'     => $this->hemoglobin,
                'blood_glucose'  => $this->blood_glucose,
            ],

            // التثقيف والعلاج
            'treatment_and_education' => [
                'dental_exam'      => $this->dental,
                'vitamins'         => $this->vitamins,
                'health_education' => $this->health_education,
                'complications'    => $this->complications,
            ],

            'created_at'       => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
