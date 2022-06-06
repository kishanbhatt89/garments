<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\TypeResource;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth:client','jwt.auth']);
    }

    public function index()
    {
        $types = Type::select('id','name')->get();        
        return new TypeResource($types);
    }
}
