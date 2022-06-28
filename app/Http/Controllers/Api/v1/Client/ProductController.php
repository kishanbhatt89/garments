<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Client\ProductImageRequest;
use App\Http\Requests\Api\v1\Client\ProductRequest;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct() {

        $this->middleware(['jwt.auth','is_client_active']);

    }

    public function store(ProductRequest $request) {

        if (auth('client')->user()->is_store_setup == 0) {
            return response()->json([                
                'msg'   => 'Store not setup. Please setup store first.',
                'status'   => false,                    
                'data'  => (object) []
            ], 200);
        }

        $client_id = auth('client')->user()->id;
        $store_id = auth('client')->user()->store->id;
        
        // Single
        if ($request->variation_type == 'single') {

            $product = new Product();

            $product->client_id = $client_id;
            $product->store_id = $store_id;
            $product->sku = $request->sku;
            $product->name = $request->name;
            $product->details = $request->details;
            $product->category_id = $request->category_id;
            $product->subcategory_id = $request->subcategory_id;
            $product->variation_type = $request->variation_type;
            $product->brand = $request->brand;
            $product->status = $request->status;

            if ($product->save()) {

                if (!empty($request->colors)) {
                    foreach ($request->colors as $color) {
                        $productColor = new ProductColor();
                        $productColor->product_id = $product->id;
                        $productColor->color_code = $color['color_code'];                        
                        $productColor->save();
                    }
                }

                return response()->json([                
                    'msg'   => 'Product stored successfully!',
                    'status'   => true,                    
                    'data'  => [
                        'product_id' => $product->id
                    ]
                ], 200);
            }            

            return response()->json([                
                'msg'   => 'Error in saving product',
                'status'   => false,                    
                'data'  => (object) []
            ], 200);

        }

        // Multiple
        if ($request->variation_type == 'multiple') {

            $variations = $request->variations;

            $product = new Product();

            $product->client_id = $client_id;
            $product->store_id = $store_id;
            $product->sku = $request->sku;
            $product->name = $request->name;
            $product->details = $request->details;
            $product->category_id = $request->category_id;
            $product->subcategory_id = $request->subcategory_id;
            $product->variation_type = $request->variation_type;
            $product->brand = $request->brand;
            $product->status = $request->status;

            if ($product->save()) {

                if (!empty($request->colors)) {
                    foreach ($request->colors as $color) {
                        $productColor = new ProductColor();
                        $productColor->product_id = $product->id;
                        $productColor->color_code = $color['color_code'];                        
                        $productColor->save();
                    }
                }

                if (!empty($variations)) {
                    foreach ($variations as $variation) {
                        $productVariation = new ProductVariation();
                        $productVariation->product_id = $product->id;
                        $productVariation->name = $variation['name'];
                        $productVariation->price = $variation['price'];
                        $productVariation->discounted_price = $variation['discounted_price'];
                        $productVariation->status = 'active';
                        $productVariation->save();
                    }
                }

                return response()->json([                
                    'msg'   => 'Product stored successfully!',
                    'status'   => true,                    
                    'data'  => [
                        'product_id' => $product->id
                    ]
                ], 200);
            }            

            return response()->json([                
                'msg'   => 'Error in saving product',
                'status'   => false,                    
                'data'  => (object) []
            ], 200);

        }

    }

    public function imageUpload(ProductImageRequest $request) {

        $product = Product::find($request->id);

        $uploadFolder = 'products';

        $image = $request->file('image');

        $image_uploaded_path = $image->store($uploadFolder, 'public');

        $product->image = basename($image_uploaded_path);
        $product->image_uploaded_url = asset('storage/products/'.$product->image);        

        if ($product->save()) {

            return response()->json([                
                'msg'   => 'Product image uploaded successfully!',
                'status'   => true,                    
                'data'  => [
                    'product_id' => $product->id,
                    'image' => $product->image,
                    'image_url' => $product->image_uploaded_url
                ]
            ], 200);

        }

        return response()->json([                
            'msg'   => 'Error in uploading product image',
            'status'   => false,                    
            'data'  => (object) []
        ], 200);


    }
    

}
