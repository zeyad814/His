<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilyPlanningFollowUpResource extends JsonResource
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
            'visit_date' => $this->visit_date,
            
            'actions' => [
                'get_method' => (bool)$this->get_method,
                'change_method' => (bool)$this->change_method,
                'follow_up_current_method' => (bool)$this->follow_up_current_method,
                'medical_complications' => (bool)$this->medical_complications,
                'remove_iud' => (bool)$this->remove_iud,
                'remove_capsule' => (bool)$this->remove_capsule,
                'reproductive_health' => (bool)$this->reproductive_health,
                'counseling' => (bool)$this->counseling,
            ],
            'referral' => $this->referral,
            'treatment' => $this->treatment,
            'dispensed_data' => [
                'method' => $this->dispensed_method,
                'quantity' => $this->quantity,
            ],
            'next_visit_date' => $this->next_visit_date,
            'notes' => $this->notes,
            // عرض اسم الدكتور اللي سجل المتابعة
            'doctor_name' => $this->doctor?->user?->name,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
