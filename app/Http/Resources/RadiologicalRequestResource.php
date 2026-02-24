<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RadiologicalRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $isIndex = $request->routeIs('doctor.radiological-requests.index');
        $isShow  = $request->routeIs('doctor.radiological-requests.show');
        $isEdit = $request->routeIs('doctor.radiological-requests.edit');
        
        return [
            'id' => $this->id,
            'family_member_name' => $this->when(
                $isIndex || $isShow,
                $this->familyMember->full_name
            ),
            'doctor_name' => $this->when(
                $isIndex || $isShow || $isEdit,
                $this->doctor?->user?->name
            ),
            'required_xray' => $this->when(
                $isIndex || $isShow || $isEdit,
                $this->required_xray
            ),
            'body_part' => $this->when(
                $isIndex || $isShow || $isEdit,
                $this->body_part
            ),
            'diagnoses_reason' => $this->when(
                $isIndex || $isShow || $isEdit,
                $this->diagnoses_reason
            ),
            'priority' => $this->when(
                $isIndex || $isShow || $isEdit,
                $this->priority
            ),
            
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}