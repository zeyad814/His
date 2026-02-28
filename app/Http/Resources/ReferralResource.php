<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReferralResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isIndex = $request->routeIs('doctor.referrals.index');
        $isShow = $request->routeIs('doctor.referrals.show');

        return [
            'id' => $this->id,
            'feedback_id' => $this->when($isShow && $this->feedbackReferral, function() {
                return $this->feedbackReferral->id;
            }),
            'family_member_name' => $this->familyMember->full_name,
            'doctor name' => $this->doctor->user->name,
            'referral_number' => $this->referral_number,
            'urgency' => $this->urgency_type,
            
            'destination' => [
                'entity' => $this->referred_to_entity,
                'specialty' => $this->specialty,
                'transport' => $this->transport_method,
            ],

            'vital_signs' => [
                'bp' => $this->bp,
                'pulse' => $this->pulse,
                'temperature' => $this->temp,
                'respiratory_rate' => $this->rr,
            ],

            'medical_details' => [
                'reason' => $this->reason_for_referral,
                'history' => $this->relevant_history,
                'exam_findings' => $this->exam_findings,
                'investigations' => $this->relevant_investigations,
                'provisional_diagnosis' => $this->provisional_diagnosis,
            ],

            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
