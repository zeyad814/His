<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SignificantDataResource extends JsonResource
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
            'record_date' => $this->record_date,
            'case_description' => $this->case_description,
            'doctor_name' => $this->doctor?->user?->name ?? 'N/A',
            "action_doctor_name" => $this->action_doctor_name,
        ];
    }
}
