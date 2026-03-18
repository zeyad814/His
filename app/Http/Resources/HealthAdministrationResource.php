<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HealthAdministrationResource extends JsonResource
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
            'name' => $this->name,
            'address' => $this->address,
            'email' => $this->email,
            'phone' => $this->phone,
            
            // بيظهر عدد الوحدات لو استخدمت withCount في الكنترولر
            'units_count' => $this->whenCounted('health_units'),
            
            // لو حابب تعرض الوحدات نفسها في الـ show فقط
            // 'health_units' => HealthUnitResource::collection($this->whenLoaded('healthUnits')),
            
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
