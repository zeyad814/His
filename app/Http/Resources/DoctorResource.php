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
        $isFullDetails = $request->routeIs('admin.doctors.*');

        return [
            'id'   => $this->id,
            'name' => $this->user?->name, // بنجيب الاسم دايماً من علاقة الـ user

            // البيانات دي هتظهر فقط لو الـ Route هو تبع الـ Admin
            'email'          => $this->when($isFullDetails, $this->user?->email),
            'phone'          => $this->when($isFullDetails, $this->phone),
            'national_id'    => $this->when($isFullDetails, $this->national_id),
            'specialization' => $this->when($isFullDetails, $this->specialization),
            'license_number' => $this->when($isFullDetails, $this->license_number),
            'start_date'     => $this->when($isFullDetails, $this->start_date),
            
            // هنا بنرجع اسم الوحدة الصحية بدل الـ ID
            'health_unit'    => $this->when($isFullDetails, $this->healthUnit?->name),
            'health_administration' => $this->when($isFullDetails, 
                $this->healthUnit?->healthAdministration?->name ?? 'N/A'
            ),
        ];
    }
}
