<?php

namespace App\Traits;

use App\Models\SuperAdmin;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

trait HasSuperAdminContext
{
    public function getAuthenticatedSuperAdmin(): SuperAdmin
    {
        $user = Auth::user();

        // التأكد إن المستخدم مسجل دخول وإن نوعه SuperAdmin
        if (!$user || $user->userable_type !== SuperAdmin::class)
        {
            $response = response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access. Admin profile not found.'
            ], 403);

            throw new HttpResponseException($response);
        }

        // إرجاع موديل SuperAdmin المرتبط باليوزر
        return $user->userable instanceof SuperAdmin ? $user->userable : throw new \Exception('Super Admin not found');
    }
}
