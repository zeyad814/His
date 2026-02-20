<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChronicDiseaseResource extends JsonResource
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
        'diagnosis' => $this->diagnosis,
        'date_diagnosed' => $this->date_diagnosed?->format('Y-m-d'),
        'risk_factors' => $this->risk_factors,
        
        'family_member' => $this->whenLoaded('familyMember', function() {
            return [
                'id' => $this->familyMember->id,
                'name' => $this->familyMember->full_name,
            ];
        }),

        'created_at' => $this->whenNotNull($this->created_at?->format('Y-m-d H:i:s')),
    ];
    
    }
}
