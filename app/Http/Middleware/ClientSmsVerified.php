<?php

namespace App\Http\Middleware;

use App\Models\Client;
use Closure;
use Illuminate\Http\Request;

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
                return response()->json([                
                    'msg' => 'You need to confirm your account. We have sent you an otp, please check your sms.',
                    'status' => false,
                    'data' => (object)[]
                ], 200); 
            }            
        }

        return $next($request);
    }
}
