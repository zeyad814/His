<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VerbalOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isIndex = $request->routeIs('doctor.verbal-orders.index');
        $isShow  = $request->routeIs('doctor.verbal-orders.show');
        $isEdit = $request->routeIs('doctor.verbal-orders.edit');

        return [
            'id' => $this->id,
            'instructions' => $this->when(
                $isIndex || $isShow || $isEdit,
                $this->instructions
            ),
            'order date time' => $this->when(
                $isIndex || $isShow || $isEdit,
                $this->order_date_time
            ),
            'is confirmed' => $this->when(
                $isIndex || $isShow,
                (bool)$this->is_confirmed
            ),
            'confirmation date time' => $this->when(
                $isShow,
                $this->confirmation_date_time
            ),
            'ordered by doctor' => $this->when(
                $isIndex || $isShow || $isEdit,
                $this->orderedByDoctor->user->name
            ),
            'confirmed by doctor' => $this->when(
                $isShow,
                $this->confirmedByDoctor?->user?->name
            ),
            "confirmation_date_time" => $this->when(
                $isShow,
                $this->confirmation_date_time
            ),
        ];
    }
}
