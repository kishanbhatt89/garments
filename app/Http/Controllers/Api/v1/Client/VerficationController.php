<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Client\ForgotPasswordRequest;
use App\Http\Requests\Api\v1\Client\OtpVerifyRequest;
use App\Http\Requests\Api\v1\Client\ResetPasswordRequest;
use App\Models\Client;
use App\Models\ClientOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class VerficationController extends Controller
{

    private $apiKey;

    public function __construct() {
        $this->apiKey = "ee0fc98c-3e1e-11ed-9c12-0200cd936042";
    }

    /*
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
    */
    
    /*
    public function emailResend() 
    {
        
        if (auth('client')->user()->hasVerifiedEmail()) 
        {
            return response()->json(["msg" => "Email already verified."], 200);
        }
    
        auth('client')->user()->sendEmailVerificationNotification();
    
        return response()->json(["msg" => "Email verification link sent on your email id"], 200);
    }
    */

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
        $otpToken = $request->otp_token;  
        
        if (!$otp || !$otpToken) {

            return response()->json([                
                'msg'   => 'Invalid token or token not found.',
                'status'   => false,
                'data'  => (object) []
            ], 200);

        }

        $verficationURL = 'https://2factor.in/API/V1/'.$this->apiKey.'/SMS/VERIFY/'.$otpToken.'/'.$otp;
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $verficationURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $responseData = json_decode($response);        

        if ($responseData) {

            if ((isset($responseData->Status) && $responseData->Status == 'Success') && (isset($responseData->Details) && $responseData->Details == 'OTP Matched')) {

                $clientDetails = ClientOtp::where('otp',$otp)->where('otp_token',$otpToken)->first();

                if ($clientDetails) {                    

                    $clientDetails->client->sms_verified_at = now();                    
                    $clientDetails->client->save();

                    return response()->json([                                
                        'msg'   => 'OTP verified successfully.',
                        'status'   => true,
                        'data'  => [                            
                            'client' => $clientDetails->client, 
                            'clientDetails' => $clientDetails->client->clientDetails,
                            'store' => $clientDetails->client->store,
                        ]
                    ], 200);

                }

            }
        }

        /*
        if ($otp == '000000') {            

            $clientOtp = ClientOtp::where('otp',$otp)->where('otp_token',$request->bearerToken())->first();
            
            if ($clientOtp) {

                $client = Client::where('id',$clientOtp->client_id)->first();

                $client->sms_verified_at = now();

                $client->save();

                return response()->json([                                
                    'msg'   => 'OTP verified successfully.',
                    'status'   => true,
                    'data'  => [
                        //'token' => JWTAuth::getToken(),
                        'client' => $client, 
                        'clientDetails' => $client->clientDetails,
                        'store' => $client->store,
                    ]
                ], 200);
                
            }

            return response()->json([                
                'msg'   => 'Invalid token or token not found.',
                'status'   => false,
                'data'  => (object) []
            ], 200);

        } 
        */

        return response()->json([                         
            'msg'   => 'Invalid otp or otp token',
            'status'   => false,
            'data'  => (object) []
        ], 200);
    }

    public function resetPasswordOtpVerfiy(OtpVerifyRequest $request) {

        $otp = $request->otp;

        $client = JWTAuth::parseToken()->authenticate();       

        if (!$request->bearerToken()) {

            return response()->json([                
                'msg'   => 'Invalid token or token not found.',
                'status'   => false,
                'data'  => (object) []
            ], 200);

        } 

        if (!$client) {

            return response()->json([                              
                'msg'   => 'Invalid token or token not found.',
                'status'   => false,
                'data'  => (object) []
            ], 200);

        }        

        if ($otp == '000000') {                        

            return response()->json([                               
                'msg'   => 'OTP verified successfully.',
                'status'   => true,
                'data'  => [
                    'token' => JWTAuth::getToken()                    
                ]
            ], 200);

        } 

        return response()->json([            
            'msg'   => 'Invalid otp',
            'status'   => false,
            'data'  => (object) []
        ], 200);
    }

    public function resetPassword(ResetPasswordRequest $request) {

        $existingPassword = $request->password; 
        $newPassword = $request->new_password;       
        $otpToken = $request->otp_token;

        $clientDetails = ClientOtp::where('otp_token',$otpToken)->where('verification_for','forgotpassword')->first();

        if($clientDetails) {

            $client = $clientDetails->client;            

            if (!Hash::check($existingPassword,$client->password)) {
                return response()->json([                               
                    'msg'   => 'Invalid current password.',
                    'status'   => false,
                    'data'  => (object) []
                ], 200);
            }

            
            $client->password = bcrypt($newPassword);
            $client->last_password_change_at = now();
            $client->save();

            return response()->json([                       
                'msg'   => 'Password changed successfully.',
                'status'   => true,
                'data'  => (object) []
            ], 200);

        }           
        
        return response()->json([                               
            'msg'   => 'Invalid otp.',
            'status'   => false,
            'data'  => (object) []
        ], 200);

    }

    public function forgotPassword(ForgotPasswordRequest $request) {
        
        $client = Client::where('phone', $request->phone)->first(); 
        
        if (!$client) {
            
            return response()->json([
                'msg'   => 'Phone number not found.',
                'status'   => false,
                'data'  => (object) []
            ], 200);        

        }

        if ($client->is_active == 0) {

            return response()->json([                
                'msg' => 'Your account is blocked please contact administrator',
                'status' => false,
                'data' => (object)[]
            ], 402);

        }
        
        $curl = curl_init();

        $sendOtpUrl = "https://2factor.in/API/V1/".$this->apiKey."/SMS/+91".$request->phone."/AUTOGEN2/Forgot%20Password";
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $sendOtpUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $responseData = json_decode($response);

        if ($responseData) {
            if (isset($responseData->Status) && $responseData->Status == 'Success') {

                $clientOTP = new ClientOtp();
                $clientOTP->client_id = $client->id;
                $clientOTP->phone = $request->phone;
                $clientOTP->otp = $responseData->OTP;
                $clientOTP->otp_token = $responseData->Details;
                $clientOTP->verification_for = 'forgotpassword';
                $clientOTP->save();

                return response()->json([                
                    'msg' => 'OTP has been sent to your registered phone number.',
                    'status' => true,
                    'data' => [
                        'otp' => $responseData->OTP,
                        'token' => $responseData->Details
                    ]
                ], 200);

            }
        }

        return response()->json([                
            'msg' => 'Error in sending otp.',
            'status' => false,
            'data' => (object)[]
        ], 200);


    }

}
