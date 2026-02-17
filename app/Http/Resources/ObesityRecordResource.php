<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ObesityRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $context = $this->additional['context'] ?? 'index';
        
            return [
                'family_member_id' => $this->when(true, $this->family_member_id),
                'visit_id' => $this->visit_id,
                'visit_date' => $this->visit_date,
                'visit_type' => $this->visit_type,
                'weight' => $this->weight,
                'height' => $this->height,
                'nutrition_counseling' => $this->nutrition_counseling,
                'dietary_plan' => $this->dietary_plan,
                'referral' => $this->referral,
                'doctor_name' => $this->doctor->user->name,
            ];
    }
}
