<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Client\LoginRequest;
use App\Http\Requests\Api\v1\Client\LogoutRequest;
use App\Http\Requests\Api\v1\Client\RegisterRequest;
use App\Http\Requests\Api\v1\Client\SessionRequest;
use App\Http\Requests\Api\v1\Client\UpdateClientRequest;
use App\Models\Client;
use App\Models\ClientDetail;
use App\Models\ClientOtp;
use App\Models\ClientToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    private $apiKey;

    public function __construct() {

        $this->apiKey = "ee0fc98c-3e1e-11ed-9c12-0200cd936042";

    }
    
    public function register(RegisterRequest $request) {

        $client = new Client();

        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->password = bcrypt($request->password);                        

        if ($client->save()) {

            // Send Email Verification To Client (Optional)

            //$client->sendEmailVerificationNotification();

            $curl = curl_init();

            $sendOtpUrl = "https://2factor.in/API/V1/".$this->apiKey."/SMS/+91".$request->phone."/AUTOGEN2/Registration%20Verification";
            
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
                    $clientOTP->verification_for = 'register';
                    $clientOTP->save();

                    return response()->json([                
                        'msg' => 'Registered successfully. OTP has been sent to your registered phone number.',
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

        return response()->json([            
            'msg' => 'Error registering client.',
            'status' => false,
            'data' => (object)[]
        ], 200);

    }

    public function login(LoginRequest $request) {

        $client = Client::where('phone', $request->phone)->first(); 
        
        if (!$client) {
            return response()->json([                
                'msg' => 'Invalid credentials.',
                'status' => false,
                'data' => (object)[]
            ], 200);
        }
        
        $credentials = array_merge($request->only('password'), ['email' => $client->email]);
            
        if (!$token = auth()->guard('client')->attempt($credentials)) {

            return response()->json([                    
                'msg'   => 'Invalid credentials',
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

        if ($client->sms_verified_at == null) {
            return response()->json([                
                'msg' => 'You need to confirm your account. We have sent you an otp, please check your sms.',
                'status' => false,
                'data' => (object)[]
            ], 200);
        }

        // $client->last_login_at = now();
        // $client->save();

        // $tokensCount = ClientToken::where('client_id', $client->id)->count();

        // if ($tokensCount == 3) {

        //     ClientToken::inRandomOrder()->first()->delete();

        //     $agent = new Agent();

        //     $device_type = '';

        //     if ($agent->isMobile()): $device_type = 'Mobile'; endif;
        //     if ($agent->isDesktop()): $device_type = 'Desktop'; endif;
        //     if ($agent->isTablet()): $device_type = 'Tablet'; endif;

        //     $client->tokens()->create([
        //         'token' => $token,
        //         'device' => $agent->device(),
        //         'device_type' => $device_type
        //     ]);
        // }            
        

        // return response()->json([
        //     'status_code' => 200,                
        //     'msg'   => '',
        //     'status'   => true,
        //     'data'  => [
        //         'otp' => '000000',
        //         'token' => $token
        //     ]
        // ], 200);
                    
        return response()->json([                             
            'msg'   => '',
            'status'   => true,
            'data'  => [
                'token' => $token,
                'first_name' => auth('client')->user()->first_name,
                'last_name' => auth('client')->user()->last_name,
                'email' => auth('client')->user()->email,
                'phone' => auth('client')->user()->phone,
                'is_store_setup' => auth('client')->user()->is_store_setup,
                'address' => isset(auth('client')->user()->clientDetails->address) ? auth('client')->user()->clientDetails->address : '',
                'store' => [
                    'name' => isset(auth('client')->user()->store->name) ? auth('client')->user()->store->name : '',
                    'type' => isset(auth('client')->user()->store->types->name) ? (auth('client')->user()->store->types->name) : '',
                    'address' => isset(auth('client')->user()->store->address) ? auth('client')->user()->store->address : '',
                    'zipcode' => isset(auth('client')->user()->store->zipcode) ? auth('client')->user()->store->zipcode : '',
                    'description' => isset(auth('client')->user()->store->description) ? auth('client')->user()->store->description : '',
                    'city' => isset(auth('client')->user()->store->city) ? auth('client')->user()->store->city : '',
                    'state' => isset(auth('client')->user()->store->state) ? auth('client')->user()->store->state->name : ''
                ]
            ]
        ], 200);        
        
    }

    public function logout(Request $request) {        

        if (!$request->bearerToken() || !auth('client')->check()) {

            return response()->json([            
                'msg'   => 'Invalid token or token not found.',
                'status'   => false,                    
                'data'  => (object) []
            ], 200);            

        }

        JWTAuth::parseToken()->invalidate(true);

        auth('client')->logout();

        return response()->json([            
            'msg'   => 'Logged Out',
            'status'   => true,                    
            'data'  => (object) []
        ], 200);
    }
    
    public function refresh(Request $request) {

        if($request->bearerToken()) {

            $current_token  = JWTAuth::getToken();

            $token          = JWTAuth::refresh($current_token);            

            if ($token) {

                return response()->json([                    
                    'msg'   => '',
                    'status'   => true,                    
                    'data'  => [
                        'token' => $token
                    ]
                ], 200);

            }

            return response()->json([                
                'msg'   => 'Invalid token or token not found.',
                'status'   => false,                    
                'data'  => (object) []
            ], 200);
            

        } else {
            
            return response()->json([                
                'msg'   => 'Invalid token or token not found.',
                'status'   => false,                    
                'data'  => (object) []
            ], 200);

        }
        
    }
    

    public function session(Request $request) {
        
        if($request->bearerToken()) {

            $client = JWTAuth::parseToken()->authenticate();

            return response()->json([                
                'msg'   => '',
                'status'   => true,
                'data'  => [                
                    'first_name' => $client->first_name,
                    'last_name' => $client->last_name,
                    'email' => $client->email,
                    'phone' => $client->phone,
                    'is_store_setup' => $client->is_store_setup,
                    'address' => isset($client->clientDetails->address) ? $client->clientDetails->address : '',
                    'store' => [
                        'name' => isset($client->store->name) ? $client->store->name : '',
                        'type' => isset($client->store->types->name) ? ($client->store->types->name) : '',
                        'address' => isset($client->store->address) ? $client->store->address : '',
                        'description' => isset($client->store->description) ? $client->store->description : '',
                        'city' => isset($client->store->city) ? $client->store->city : '',
                        'zipcode' => isset($client->store->zipcode) ? $client->store->zipcode : '',
                        'state' => isset($client->store->state) ? $client->store->state->name : ''
                    ]
                ]
            ], 200);

        } else {

            return response()->json([                
                'msg'   => 'Invalid token or token not found.',
                'status'   => false,                    
                'data'  => (object) []
            ], 200);

        }

        
    }

    public function invalidate(Request $request) {

        $client = JWTAuth::parseToken()->authenticate();
        
        if (auth('client')->invalidate(true)) {

            return response()->json([                
                'msg'   => 'Token invalidated.',
                'status'   => true,
                'data'  => (object) []
            ], 200);

        }

        return response()->json([            
            'msg'   => 'Invalid token or token not found.',
            'status'   => false,                    
            'data'  => (object) []
        ], 200);

    }

    public function update(UpdateClientRequest $request) {        

        $updateClientArray = [];        
        
        if ($request->first_name) $updateClientArray['first_name'] = $request->first_name;
        if ($request->last_name) $updateClientArray['last_name'] = $request->last_name;                         

        if (!empty($updateClientArray)) {
            Client::where('id',auth('client')->user()->id)->update($updateClientArray);
        }        

        if (!empty($updateClientArray)) {
            return response()->json([                
                'msg'   => 'Profile updated successfully.',
                'status'   => true,
                'data'  => (object) []
            ], 200);    
        }

        return response()->json([            
            'msg'   => 'Error updating profile.',
            'status'   => false,                    
            'data'  => (object) []
        ], 200);

    }

}
