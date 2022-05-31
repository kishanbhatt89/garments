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
        $client = new Client();

        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->password = bcrypt($request->password);                        

        if ($client->save()) 
        {

            $client->sendEmailVerificationNotification();

            $token = auth()->guard('client')->attempt(request(['email', 'password']));

            return response()->json([
                'status_code' => 200,
                'msg' => 'Registered successfully. OTP has been sent to your registered phone number.',
                'status' => true,
                'data' => [
                    'otp' => '000000',
                    'token' => $token
                ]
            ], 200);

        }

        // Send SMS Verification Code

        return response()->json([
            'status_code' => 200,
            'msg' => 'Error registering client',
            'status' => false,
            'data' => []
        ], 200);
    }

    public function login(LoginRequest $request)
    {
        $client = Client::where('phone', $request->phone)->first(); 
        
        if ($client) {            

            $credentials = array_merge($request->only('password'), ['email' => $client->email]);
            
            if (!$token = auth()->guard('client')->attempt($credentials)) {

                return response()->json([
                    'status_code' => 200,
                    'msg'   => 'Invalid credentials',
                    'status'   => false,                    
                    'data'  => []
                ], 200);
    
            }

            return response()->json([
                'status_code' => 200,                
                'msg'   => 'OTP has been sent to your registered phone number.',
                'status'   => true,
                'data'  => [
                    'otp' => '000000' ,          
                    'token' => $token        
                ]
            ], 200);

        }        

        return response()->json([
            'status_code' => 200,
            'msg'   => 'Invalid credentials',
            'status'   => false,                    
            'data'  => []
        ], 200);
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

            return response()->json(['message' => 'Token not found'], 200);

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
