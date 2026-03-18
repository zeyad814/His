<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NurseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isFullDetails = $request->routeIs('admin.nurses.*');

        return [
            'id'   => $this->id,
            'name' => $this->user?->name,

            // بيانات تظهر فقط للأدمن في روتات الممرضات
            'email'          => $this->when($isFullDetails, $this->user?->email),
            'phone'          => $this->when($isFullDetails, $this->phone),
            'national_id'    => $this->when($isFullDetails, $this->national_id),
            'license_number' => $this->when($isFullDetails, $this->license_number),
            
            // اسم الوحدة الصحية
            'health_unit'    => $this->when($isFullDetails, $this->healthUnit?->name),

            // اسم الإدارة الصحية (علاقة متداخلة)
            'health_administration' => $this->when($isFullDetails, 
                $this->healthUnit?->healthAdministration?->name ?? 'N/A'
            ),

            'created_at'     => $this->when($isFullDetails, $this->created_at?->format('Y-m-d')),
        ];
    }
}
