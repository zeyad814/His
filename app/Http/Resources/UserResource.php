<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            $this->role => $this->when($this->userable, function () {
                // لو ال user هو doctor
                switch ($this->role) {
                    case 'doctor':
                        return new DoctorResource($this->userable);

                    case 'admin':
                        return new AdminResource($this->userable);

                    // case 'receptionist':
                    //     return new ReceptionistResource($this->userable);

                    default:
                        return null;
                }
            }),
        ];
    }
}
