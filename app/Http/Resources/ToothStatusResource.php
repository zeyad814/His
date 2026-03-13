<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ToothStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'tooth_number' => (int) $this->tooth_number,
            'crown_status' => (int) $this->crown_status,
            'root_status'  => (int) $this->root_status,
        ];
    }
}
