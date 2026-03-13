<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DentalExaminationResource extends JsonResource
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
            'family_member_id' => $this->familyMember->full_name,
            'doctor_name' => $this->doctor->user->name,
            'occupation' => $this->occupation,
            'location_type' => (int) $this->location_type,
            
            // Clinical Examination
            'extra_oral_exam' => (int) $this->extra_oral_exam,
            'tmj_symptom' => (int) $this->tmj_symptom,
            'tmj_signs' => (int) $this->tmj_signs,
            'tmj_clicking' => (bool) $this->tmj_clicking,
            'tmj_tenderness' => (bool) $this->tmj_tenderness,
            'tmj_reduced_mobility' => (bool) $this->tmj_reduced_mobility,
            
            // Mucosa
            'mucosa_condition' => (int) $this->mucosa_condition,
            'mucosa_location' => (int) $this->mucosa_location,
            'mucosa_other' => $this->mucosa_other,
            
            // Indexes & Assessment
            'cpi_sections' => $this->cpi_sections, // تأكد إنك عامل cast لـ array في الموديل
            'fluorosis_index' => (int) $this->fluorosis_index,
            'trauma_index' => (int) $this->trauma_index,
            'white_spot_lesions' => $this->white_spot_lesions,
            'enamel_defects' => $this->enamel_defects,
            'developmental_anomalies' => $this->developmental_anomalies,
            'clefts' => $this->clefts,
            'occlusion_class' => (int) $this->occlusion_class,
            'primary_mesial_step' => $this->primary_mesial_step,
            
            // Timestamps
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            
            // Relationship (Tooth Statuses)
            'tooth_statuses' => ToothStatusResource::collection($this->whenLoaded('toothStatuses')),
        ];
    }
}
