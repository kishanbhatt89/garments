<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Client\CreateStoreRequest;
use App\Http\Requests\Api\v1\Client\UpdateStoreRequest;
use App\Http\Resources\Api\v1\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class StoreController extends Controller
{

    public function __construct() 
    {
        $this->middleware(['auth:client','jwt.auth']);
    }    

    public function show(Store $store)
    {                                    
        return new StoreResource($store);        
    }
    
    public function store(CreateStoreRequest $request)
    {
        auth('client')->user()->is_store_setup = true;

        auth('client')->user()->save();
    
        $store = auth('client')->user()->store()->create($request->all());

        if ($store) {
            return new StoreResource($store);
        } else {
            return response()->json(['msg'=> 'Something went wrong'], 400);
        }

    }
        
    public function update(UpdateStoreRequest $request, $id)
    {                                
        $store = Store::find($id);

        if (!$store) {
            return response()->json(['msg'=> 'Store not found.'], 400);
        }
        
        if ($store->update($request->all())) {
            return new StoreResource($store);
        } else {
            return response()->json(['msg'=> 'Something went wrong'], 400);
        }                
    }
    
    public function destroy($id)
    {        
        $store = Store::find($id);

        if (!$store) {
            return response()->json(['msg'=> 'Store not found.'], 400);
        }
        
        if ($store->delete()) {
            return response()->json(['msg'=> 'Store deleted successfully.'], 200);
        } else {
            return response()->json(['msg'=> 'Something went wrong'], 400);
        }        
    }
}
