<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilyBasicResource extends JsonResource
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
            'family_code' => $this->family_code,
            'national_id' => $this->national_id,
            'head_name' => $this->head_name,
            'governorate' => $this->governorate,
            'village_or_city' => $this->village_or_city,
            'health_department' => $this->health_department,
            'health_unit' => $this->health_unit,
            'address' => $this->address,
            'mobile_phone' => $this->mobile_phone,
            'work_phone' => $this->work_phone,
            'nearest_phone' => $this->nearest_phone,
        ];
    }
}
