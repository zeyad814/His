<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HealthUnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'code'    => $this->code,
            'address' => $this->address,
            'city'    => $this->city,
            'email'   => $this->email,
            'phone'   => $this->phone,

            // اسم الإدارة الصحية التابعة لها
            'health_administration' => $this->healthAdministration?->name ?? 'N/A',
            
            'doctors_count' => $this->whenCounted('doctors'),
            
            'nurses_count'  => $this->whenCounted('nurses'),

            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
