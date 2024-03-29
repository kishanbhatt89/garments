<?php

namespace App\Http\Middleware;

use App\Models\Client;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ClientSmsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {           
        if (auth('client')->user()) {

            if (auth('client')->user()->sms_verified_at == null) {
                auth('client')->logout();

                return response()->json([                
                    'msg' => 'You need to confirm your account. We have sent you an otp, please check your sms.',
                    'status' => false,
                    'data' => (object)[]
                ], 200);                        

            }
            
        }

        if (request()->get('email')) {

            $client = Client::where('email',request()->get('email'))->first();

            if ($client && $client->sms_verified_at === null) {

                $otp = '000000';
                $otpToken = Str::random(30);                

                $client->otps()->create([                    
                    'otp' => $otp,
                    'otp_token' => $otpToken
                ]);

                return response()->json([                
                    'msg' => 'You need to confirm your account. We have sent you an otp, please check your sms.',
                    'status' => false,
                    'data' => [
                        'otp' => $otp,
                        'token' => $otpToken
                    ]
                ], 200); 
            }            
        }

        return $next($request);
    }
}
