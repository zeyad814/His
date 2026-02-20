<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChronicDiseaseVisitResource extends JsonResource
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
        'doctor_id' => $this->doctor_id,
        'visit_id' => $this->visit_id,
        'chronic_disease_id' => $this->chronic_disease_id,
        'complain' => $this->complain,
        'exam' => $this->exam,
        'vital_signs' => $this->vital_signs,
        'investigations' => $this->investigations,
        'management' => $this->management,
        'notes' => $this->notes,
        'visit_date' => $this->visit_date,
        ];
    }
}
