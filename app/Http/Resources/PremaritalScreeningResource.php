<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PremaritalScreeningResource extends JsonResource
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
        'type'             => $this->type, // groom or bride
        'applicant_name'   => $this->familyMember?->full_name,
        
        'gender_text'      => $this->familyMember?->is_male == 1 ? 'male' : 'female', 
        'national_id'      => $this->national_id, 
        
        'medical_history'  => [
            'consanguinity'      => $this->consanguinity,
            'chronic_diseases'   => $this->chronic_diseases,
            'hereditary_diseases'=> $this->hereditary_diseases,
        ],
        
        'physical_examination' => [
            'blood_pressure' => $this->blood_pressure,
            'pulse'          => $this->pulse,
            'bmi_details'    => [
                'weight' => $this->weight,
                'height' => $this->height,
                'bmi'    => $this->bmi,
            ],
        ],
        
        'lab_results' => [
            'blood_sugar'      => $this->blood_sugar,
            'hemoglobin'       => $this->hemoglobin_level,
            'blood_group_rh'   => $this->blood_group_rh,
        ],
        
        'doctor' => [
            'id'   => $this->doctor_id,
            'name' => $this->doctor->user->name ?? 'N/A',
        ],
        
        'examination_date' => $this->examination_date ? $this->examination_date->format('Y-m-d') : null,
    ];
        
    }
}
