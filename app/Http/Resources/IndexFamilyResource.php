<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexFamilyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            'family_code' => $this->family_code,
            'head_name'   => $this->head_name,
            'national_id' => $this->national_id,
            'updated_at'  => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
