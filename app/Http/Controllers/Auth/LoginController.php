<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', '=', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password))
        {
            return ApiResponse::errorResponse('Invalid credentials', 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;
        // $userData = $user->userable;
        $user->load('userable');

        // return response()->json([
        //     'user' => new UserResource($user),
        //     'token' => $token
        // ]);
        $data = [
            'user' => new UserResource($user),
            'token' => $token
        ];

        return ApiResponse::successResponse('Login successful', 200, $data);
    }
}
