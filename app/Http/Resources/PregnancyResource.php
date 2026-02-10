<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PregnancyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                     => $this->id,
            // بنجيب الاسم من علاقة الـ familyMember اللي في الموديل
            'patient_name'           => $this->familyMember ? $this->familyMember->full_name : 'N/A',
            'family_member_id'       => $this->family_member_id,
            'pregnancy_status'       => $this->pregnancy_status,
            'last_menstrual_period'  => $this->last_menstrual_period,
            'expected_delivery_date' => $this->expected_delivery_date,
            'gravidity'              => $this->gravidity,
            'parity'                 => $this->parity,
            'abortions'              => $this->abortions,
            'living_children'        => $this->living_children,
            'previous_stillbirths'   => $this->previous_stillbirths,
            'previous_cesarean'      => $this->previous_cesarean,
            'blood_type'             => $this->blood_type,
            'rh_factor'              => $this->rh_factor,
            'syphilis_test_result'   => $this->syphilis_test_result,
            'last_tetanus_date'      => $this->last_tetanus_date,
            'tetanus_doses'          => $this->tetanus_doses,
            'tetanus_immunity_status'=> $this->tetanus_immunity_status,
            'consanguinity'          => (bool) $this->consanguinity, // تحويل لـ true/false
            'created_at'             => $this->created_at ? $this->created_at->format('Y-m-d') : null,
            'visits_history'         => PregnancyVisitResource::collection($this->whenLoaded('pregnancyVisits')),
            
        ];
    }
}
