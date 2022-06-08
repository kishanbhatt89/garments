<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['jwt.auth','is_client_active']);
    }

    public function index()
    {
        $categories = Category::select('id','name','slug')->where('parent_id',0)->get();        
        return new CategoryResource($categories);
    }
}
