<?php

namespace App\Traits;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;

trait HasAdminContext
{
    /**
     * الحصول على بيانات الأدمن (مدير المنشأة) المسجل حالياً
     */
    public function getAuthenticatedAdmin(): Admin
    {
        $user = Auth::user();

        // التأكد إن المستخدم مسجل دخول وإن نوعه Admin
        if (!$user || $user->userable_type !== Admin::class)
        {
            $response = response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access. Admin profile not found.'
            ], 403);

            throw new HttpResponseException($response);
        }

        // إرجاع موديل الأدمن المرتبط باليوزر
        return $user->userable instanceof Admin ? $user->userable : throw new \Exception('Admin not found');
    }
}