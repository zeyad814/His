<?php

namespace App\Traits;

use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

trait HasDoctorContext
{
    public function getAuthenticatedDoctor(): Doctor
    {
        $user = Auth::user();

        if (!$user || $user->userable_type !== Doctor::class)
        {
            // abort(403, 'Unauthorized access. Doctor profile not found.');
            $response = response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access. Doctor profile not found.'
            ], 403);

            throw new \Illuminate\Http\Exceptions\HttpResponseException($response);
        }

        return $user->userable instanceof Doctor ? $user->userable : throw new \Exception('Doctor not found');
    }
}
