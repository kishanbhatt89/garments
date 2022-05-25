<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Client\LoginRequest;
use App\Http\Requests\Api\v1\Client\LogoutRequest;
use App\Http\Requests\Api\v1\Client\RegisterRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    
    public function register(RegisterRequest $request)
    {
        $client = Client::create(array_merge(
            $request->except('password'),
            ['password' => bcrypt($request->password)]
        ))->sendEmailVerificationNotification();        

        // Send SMS Verification Code

        return response()->json([
            'message' => 'Client successfully registered',
            'client' => auth('client')->user()
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->guard('client')->attempt($credentials)) {

            return response()->json(['error' => 'Unauthorized'], 401);

        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('client')->factory()->getTTL() * 60
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(LogoutRequest $request)
    {        
        if (!$request->bearerToken() || !auth('client')->check()) {

            return response()->json(['message' => 'Token not found'], 401);

        }

        auth('client')->logout();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('client')->refresh());
    }


}
