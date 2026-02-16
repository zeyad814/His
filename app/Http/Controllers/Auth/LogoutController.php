<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class LogoutController extends Controller
{
    use ApiResponse;

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user)
        {
            /** @var PersonalAccessToken $token */
            $token = $user->currentAccessToken();
            
            if ($token)
            {
                $token->delete();
            }
        }

        return $this->successResponse('Logged out successfully', 200);
    }
}