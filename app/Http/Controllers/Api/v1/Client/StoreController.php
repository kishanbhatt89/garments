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
        $this->middleware(['jwt.auth']);
    }    

    public function show(Store $store)
    {                                    
        return new StoreResource($store);        
    }
    
    public function store(CreateStoreRequest $request)
    {
        auth('client')->user()->is_store_setup = true;

        auth('client')->user()->save();
        
        $data = $request->except(['state','type']);
        
        $data['state_id'] = $request->state;
        $data['type_id'] = intval($request->type);

        $store = auth('client')->user()->store()->create($data);
        
        if ($store) {
            return new StoreResource($store);
        } else {
            return response()->json([
                'status_code' => 200,
                'msg'   => 'Error in setting up store',
                'status'   => false,                    
                'data'  => (object) []
            ], 200);
        }

    }
        
    // public function update(UpdateStoreRequest $request, $id)
    // {                                
    //     $store = Store::find($id);

    //     if (!$store) {
    //         return response()->json(['msg'=> 'Store not found.'], 200);
    //     }
        
    //     if ($store->update($request->all())) {
    //         return new StoreResource($store);
    //     } else {
    //         return response()->json(['msg'=> 'Something went wrong'], 200);
    //     }                
    // }
    
    // public function destroy($id)
    // {        
    //     $store = Store::find($id);

    //     if (!$store) {
    //         return response()->json(['msg'=> 'Store not found.'], 200);
    //     }
        
    //     if ($store->delete()) {
    //         return response()->json(['msg'=> 'Store deleted successfully.'], 200);
    //     } else {
    //         return response()->json(['msg'=> 'Something went wrong'], 200);
    //     }        
    // }
}
