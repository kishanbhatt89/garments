<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\StoreResource;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class StoreController extends Controller
{

    public function __construct() 
    {
        $this->middleware('auth:api');
    }    

    public function show(Store $store)
    {                            
        $user = User::find(1);
        
        if ($user->hasPermissionTo('role_management-create')) {
            return response()->json(['data'=> 'User has permission.'], 200);    
        } else {
            return response()->json(['data'=> 'User does not have permission.'], 400);    
        }

        $this->authorize('view', $store);

        return new StoreResource($store);        
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:stores',
            'address' => 'required|string',
            'email' => 'required|string|email|unique:stores',
            'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }

        $store = auth('api')->user()->store()->create($request->all());

        if ($store) {
            return new StoreResource($store);
        } else {
            return response()->json(['data'=> 'Something went wrong'], 400);
        }

    }
        
    public function update(Request $request, Store $store)
    {                        

        $this->authorize('update', $store);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|unique:stores,name,'.$store->id,
            'address' => 'sometimes',
            'email' => 'sometimes|email|unique:stores,email,'.$store->id,
            'phone' => 'sometimes',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }

        $store->update($request->all());

        return new StoreResource($store);   
    }
    
    public function destroy(Store $store)
    {
        $this->authorize('delete', $store);   

        $store->delete();
    }
}
