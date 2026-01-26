<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            'name' => $this->user->name,
            // 'family_id' => $this->family_id,
            // 'health_unit_id' => $this->health_unit_id,
            // 'national id' => $this->national_id,
            // 'phone' => $this->phone,
            // 'specialization' => $this->specialization,
            // 'license number' => $this->license_number,
            // 'start date' => $this->start_date,
        ];
    }
}
