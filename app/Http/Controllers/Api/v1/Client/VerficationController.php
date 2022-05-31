<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Client\ForgotPasswordRequest;
use App\Http\Requests\Api\v1\Client\OtpVerifyRequest;
use App\Http\Requests\Api\v1\Client\ResetPasswordRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerficationController extends Controller
{
    public function emailVerify($client_id, Request $request) 
    {
        if (!$request->hasValidSignature()) 
        {
            return response()->json(["msg" => "Invalid/Expired url provided."], 200);
        }
    
        $client = Client::findOrFail($client_id);
    
        if (!$client->hasVerifiedEmail()) 
        {
            $client->markEmailAsVerified();
        }
    
        return response()->json(['msg' => 'Email verified successfully.'], 200);
    }
    
    public function emailResend() 
    {
        
        if (auth('client')->user()->hasVerifiedEmail()) 
        {
            return response()->json(["msg" => "Email already verified."], 200);
        }
    
        auth('client')->user()->sendEmailVerificationNotification();
    
        return response()->json(["msg" => "Email verification link sent on your email id"], 200);
    }

    /*
    public function smsVerify($client_id, Request $request)
    {
        $client = Client::where('id', $client_id)->update(['sms_verified_at' => now()]);

        if ($client) 
        {
            return response()->json(['msg' => 'Phone verified successfully.'], 200);    
        }

        return response()->json(['msg' => 'Something went wrong!'], 400);
    }
    */

    public function otpVerfiy(OtpVerifyRequest $request)
    {
        $otp = $request->otp;
        $token = $request->token;

        $client = JWTAuth::parseToken()->authenticate();        

        if (!$client) 
        {
            return response()->json([
                'status_code' => 200,                
                'msg'   => 'Invalid token',
                'status'   => false,
                'data'  => (object) []
            ], 200);
        }        

        if ($otp == '000000') 
        {            

            $client->sms_verified_at = now();
            $client->save();

            return response()->json([
                'status_code' => 200,                
                'msg'   => 'OTP verified successfully.',
                'status'   => true,
                'data'  => [
                    'token' => $token,
                    'client' => $client, 
                    'clientDetails' => $client->clientDetails,
                    'store' => $client->store,
                ]
            ], 200);

        } 

        return response()->json([
            'status_code' => 200,                
            'msg'   => 'Invalid otp',
            'status'   => false,
            'data'  => (object) []
        ], 200);
    }

    public function resetPasswordOtpVerfiy(OtpVerifyRequest $request)
    {
        $otp = $request->otp;
        $token = $request->token;

        $client = JWTAuth::parseToken()->authenticate();        

        if (!$client) 
        {
            return response()->json([
                'status_code' => 200,                
                'msg'   => 'Invalid token',
                'status'   => false,
                'data'  => (object) []
            ], 200);
        }        

        if ($otp == '000000') 
        {                        

            return response()->json([
                'status_code' => 200,                
                'msg'   => 'OTP verified successfully.',
                'status'   => true,
                'data'  => [
                    'token' => $token                    
                ]
            ], 200);

        } 

        return response()->json([
            'status_code' => 200,                
            'msg'   => 'Invalid otp',
            'status'   => false,
            'data'  => (object) []
        ], 200);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $password = $request->password;
        $token = $request->token;

        $client = JWTAuth::parseToken()->authenticate();        

        if (!$client) 
        {
            return response()->json([
                'status_code' => 200,                
                'msg'   => 'Invalid token',
                'status'   => false,
                'data'  => (object) []
            ], 200);
        }        

        $client->password = bcrypt($password);
        $client->save();

        return response()->json([
            'status_code' => 200,                
            'msg'   => 'Password changed successfully.',
            'status'   => true,
            'data'  => (object) []
        ], 200);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $client = Client::where('phone', $request->phone)->first();

        if (!$client) {
            return response()->json([
                'status_code' => 200,                
                'msg'   => 'Invalid phone number',
                'status'   => false,
                'data'  => (object) []
            ], 200);
        }

        Auth::login($client);

        $token = auth('client')->refresh();

        return response()->json([
            'status_code' => 200,
            'msg' => '',
            'status' => true,
            'data' => [
                'otp' => '000000',
                'token' => $token
            ]
        ], 200);

    }

}
