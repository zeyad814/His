<?php
namespace App\Traits;

use App\Models\Nurse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;

trait HasNurseContext
{
    public function getAuthenticatedNurse()
    {
        $user = Auth::user();

        if(!$user || $user->userable_type !== Nurse::class)
        {
           $response = response()->json([
            'status' => 'error',
            'message' => 'Unauthorized access. Nurse profile not found.'
           ], 403);

           throw new HttpResponseException($response);
        }

        if ($user->userable instanceof Nurse){
            return $user->userable;
        }

        throw new \Exception('Nurse profile record missing');
    }
}


