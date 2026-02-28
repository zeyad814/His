<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackReferralResource extends JsonResource
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
            'referral_id' => $this->referral_id,
            'doctor_name' => $this->doctor->user->name,
            'arrival_time' => $this->arrival_at ? $this->arrival_at->format('Y-m-d H:i') : null,

            // النتائج الطبية
            'clinical_findings' => [
                'specialist_findings' => $this->specialist_findings,
                'hospital_investigations' => $this->hospital_investigations,
                'final_diagnosis' => $this->final_diagnosis,
                'current_medications' => $this->current_medications,
            ],

            // التدخلات الطبية (Interventions)
            'interventions' => [
                'admission_ward' => $this->admission_ward,
                'surgery_type' => $this->surgery_type,
                'other_interventions' => $this->other_interventions,
            ],

            // التوصيات والمتابعة
            'recommendations_and_follow_up' => [
                'recommendations' => $this->recommendations,
                'revisit_date' => $this->revisit_date,
                'sick_leave_days' => $this->sick_leave_days,
                'follow_up_instructions' => $this->follow_up_instructions,
            ],

            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
