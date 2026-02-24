<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RadiologyReportResource extends JsonResource
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
            'doctor_name' => $this->doctor->user->name,
            'findings_text' => $this->findings_text,
            'radiation_dose' => $this->radiation_dose,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
