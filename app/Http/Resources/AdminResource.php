<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isAdminRoute = $request->routeIs('super-admin.admins.*');

        return [
            'id' => $this->id,
            'national id' => $this->national_id,

            'name' => $this->when($isAdminRoute, $this->user?->name),
            'email' => $this->when($isAdminRoute, $this->user?->email),
            'phone' => $this->when($isAdminRoute, $this->phone),
            'health unit name' => $this->when($isAdminRoute, $this->healthUnit?->name ?? 'N/A'),
            'created at' => $this->when($isAdminRoute, $this->created_at?->format('Y-m-d H:i:s')),
        ];
    }
}
