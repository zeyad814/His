<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostnatalCareResource extends JsonResource
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
            'pregnancy_info' => [
                'id'           => $this->pregnancy_id,
                'patient_name' => $this->pregnancy->familyMember->full_name ?? 'N/A',
                'status'       => $this->pregnancy->pregnancy_status,
            ],
            'doctor_name'      => $this->doctor ? $this->doctor->name : 'N/A', // اسم الدكتور بدل الـ ID
            'visit_date'       => $this->visit_date,

            // 1. ناتج الولادة (Delivery Outcome)
            'delivery_info' => [
                'type'           => $this->delivery_type,
                'date'           => $this->delivery_date,
                'baby_status'    => $this->baby_status,
                'place'          => $this->delivery_place,
                'attended_by'    => $this->attended_by,
                'complications'  => $this->delivery_complications,
            ],

            // 2. سجل زيارات النفاس (PNC Visits)
            'pnc_visits_history' => [
                'first_visit'  => ['date' => $this->first_pnc_visit_date, 'result' => $this->first_pnc_visit_result],
                'second_visit' => ['date' => $this->second_pnc_visit_date, 'result' => $this->second_pnc_visit_result],
                'third_visit'  => ['date' => $this->third_pnc_visit_date, 'result' => $this->third_pnc_visit_result],
            ],

            // 3. التقييم الطبي (Clinical Assessment)
            'clinical_assessment' => [
                'breastfeeding' => [
                    'type'       => $this->breastfeeding_type,
                    'assessment' => $this->breastfeeding_assessment,
                    'problems'   => $this->breastfeeding_problems,
                ],
                'depression_screening' => $this->depression_screening,
                'social_adjustment'    => $this->social_adjustment,
                'maternal_concerns'    => $this->maternal_concerns,
                'health_education'     => $this->health_education,
            ],

            // 4. تنظيم الأسرة (Family Planning)
            'family_planning' => [
                'method' => $this->contraception_method,
                'date'   => $this->contraception_date,
            ],

            'additional_notes' => $this->additional_notes,
            'created_at'       => $this->created_at->format('Y-m-d'),
        ];
    }
}
