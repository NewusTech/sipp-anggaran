<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'logout']]);
    }

    public function loginResponse($token, $user)
    {
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token,
            'type' => 'Bearer',
            'app_name' => 'SIPP-Anggaran'
        ];

        return response()->json([
            'success' => true,
            'message' => 'Login Success',
            'data' => $data
        ], 200);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        if ($token = auth('api')->attempt($credentials)) {
            return $this->loginResponse($token, auth('api')->user());
        }
        return response()->json([
            'error' => 'Unauthorized'
        ], 401);
    }

    public function getUserData()
    {
        try {
            $user = auth('api')->user();
            return response()->json([
                'success' => true,
                'message' => 'Get User Data Success',
                'data' => $user
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
    public function logout()
    {
        auth('api')->logout();
        return response()->json([
            'success' => true,
            'message' => 'Logout Success'
        ], 200);
    }
}
