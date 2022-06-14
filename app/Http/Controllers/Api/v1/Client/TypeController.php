<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\TypeResource;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function __construct() {

        $this->middleware(['jwt.auth','is_client_active']);

    }

    public function index() {

        $types = Type::select('id','name')->get();  
        
        if ($types->isEmpty()) {
            return [            
                'msg' => '',
                'status' => true,
                'data' => (object)[]                
            ];
        }
        
        return (new TypeResource($types))->response()->setStatusCode(200);

    }
}
