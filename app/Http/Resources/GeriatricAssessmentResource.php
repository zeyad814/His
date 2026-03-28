<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GeriatricAssessmentResource extends JsonResource
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
            'overall_status'         => $this->overall_status,
            'doctor_recommendations' => $this->doctor_recommendations,
            'created_at'             => $this->created_at->format('Y-m-d'),
            'family_member' => [
                'id' => $this->family_member_id,
                'name' => $this->familyMember?->full_name,
            ],
            'doctor_info' => [
                'id' => $this->doctor_id,
                'name' => $this->doctor?->user->name ?? 'N/A',
            ],
            'assessment_data'        => AssessmentAnswerResource::collection($this->whenLoaded('answers')),
        ];
    }
    
}
