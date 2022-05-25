<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class VerficationController extends Controller
{
    public function emailVerify($client_id, Request $request) 
    {
        if (!$request->hasValidSignature()) 
        {
            return response()->json(["msg" => "Invalid/Expired url provided."], 401);
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
            return response()->json(["msg" => "Email already verified."], 400);
        }
    
        auth('client')->user()->sendEmailVerificationNotification();
    
        return response()->json(["msg" => "Email verification link sent on your email id"], 200);
    }

    public function smsVerify($client_id, Request $request)
    {
        $client = Client::where('id', $client_id)->update(['sms_verified_at' => now()]);

        if ($client) 
        {
            return response()->json(['msg' => 'Phone verified successfully.'], 200);    
        }

        return response()->json(['msg' => 'Something went wrong!'], 400);
    }

}
