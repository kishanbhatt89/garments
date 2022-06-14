<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\StateResource;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{

    public function __construct() {

        $this->middleware(['jwt.auth','is_client_active']);

    }

    public function index() {

        $states = State::select('id','name')->get(); 
        
        if ($states->isEmpty()) {
            return [            
                'msg' => '',
                'status' => true,
                'data' => (object)[]                
            ];
        }
             
        return (new StateResource($states))->response()->setStatusCode(200);

    }

}
