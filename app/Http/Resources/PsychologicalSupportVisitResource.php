<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PsychologicalSupportVisitResource extends JsonResource
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
            // 'family_member_id' => $this->family_member_id,
            'visit_date' => $this->visit_date,
            'family member' => $this->when(
                $request->routeIs('doctor.psychological-support.edit'),
                $this->family_member_id
            ),
            'questionnaire type' => $this->questionnaire_type,
            'visit reason' => $this->visit_reason,
            'questionnaire result' => $this->questionnaire_result,
            'initial diagnosis' => $this->initial_diagnosis,
            'treatment plan' => $this->treatment_plan,
            'referral location' => $this->referral_location,
        ];
    }
}
