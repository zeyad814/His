<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilyInjectionResource extends JsonResource
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
        'procedure_name'   => $this->procedure_name,
        'phone'            => $this->phone,
        'is_agreed'        => (bool) $this->is_agreed, 
        'visit_date'       => $this->visit_date,
        'visit_time'       => $this->visit_time,
        
        
        'national_id'      => $this->national_id,

        // بيانات الطبيب بشكل مختصر
        'doctor' => [
            'id'   => $this->doctor_id,
            'name' => $this->doctor?->user?->name, 
        ],

        // بيانات عضو العائلة (المريضة)
        'patient' => [
            'id'   => $this->family_member_id,
            'name' => $this->familyMember?->full_name,
        ],

        'created_at'       => $this->created_at->format('Y-m-d H:i:s'),
    ];
    }
}
