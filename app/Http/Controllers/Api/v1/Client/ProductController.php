<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Client\ProductImageRequest;
use App\Http\Requests\Api\v1\Client\ProductRequest;
use App\Http\Requests\Api\v1\Client\ShowProductRequest;
use App\Http\Resources\Api\v1\ProductResource;
use App\Http\Resources\Api\v1\SingleProductResource;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct() {

        $this->middleware(['jwt.auth','is_client_active']);

    }

    public function index() {
        $products = Product::all();

        if ($products->count() > 0) {
            return (new ProductResource($products))->response()->setStatusCode(200);
        }

        return [            
            'msg' => 'No products found.',
            'status' => false,
            'data' => (object)[]                
        ];
        
    }

    public function show(ShowProductRequest $request) {

        $product = Product::find($request->id);

        if ($product) {
            return (new SingleProductResource($product))->response()->setStatusCode(200);
        }
        return [            
            'msg' => 'Product not found.',
            'status' => false,
            'data' => (object)[]                
        ];
    }

    public function store(ProductRequest $request) {

        if (auth('client')->user()->is_store_setup == 0) {
            return response()->json([                
                'msg'   => 'Store not setup. Please setup store first.',
                'status'   => false,                    
                'data'  => (object) []
            ], 200);
        }

        if ($request->sku) {
            $product = Product::where('sku', $request->sku)->first();
            if ($product) {
                return response()->json([                
                    'msg'   => 'Product with same sku already exists.',
                    'status'   => false,                    
                    'data'  => (object) []
                ], 200);
            }
        }

        $client_id = auth('client')->user()->id;
        $store_id = auth('client')->user()->store->id;
        
        // Single
        if ($request->variation_type == 'single') {

            $product = new Product();

            $product->client_id = $client_id;
            $product->store_id = $store_id;
            $product->sku = $request->sku ? $request->sku : '';
            $product->name = $request->name;
            $product->details = $request->details;
            $product->category_id = $request->category_id;
            $product->subcategory_id = $request->subcategory_id;
            $product->variation_type = $request->variation_type;
            $product->brand = $request->brand ? $request->brand : '';
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

                $variations = $request->variations;

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

        if ($product->images->count() > 5) {
            return response()->json([                
                'msg'   => 'You can upload maximum 5 images. Please delete some images first.',
                'status'   => false,                    
                'data'  => (object) []
            ], 200);
        }

        $uploadFolder = 'products';

        $images = $request->file('images');

        foreach ($images as $image) {

            $image_uploaded_path = $image->store($uploadFolder, 'public');
            $imageName = basename($image_uploaded_path);
            $imageUrl = asset('storage/products/'.$product->image);        

            $productImage = new ProductImage();

            $productImage->product_id = $product->id;
            $productImage->image = $imageName;
            $productImage->image_uploaded_url = $imageUrl;

            $productImage->save();

            $productResponse[] = [
                'product_id' => $productImage->product_id,
                'image' => $productImage->image_uploaded_url.'/'.$productImage->image,                
            ];

        }

        return response()->json([                
            'msg'   => 'Product image uploaded successfully!',
            'status'   => true,                    
            'data'  => $productResponse
        ], 200);
        

        // return response()->json([                
        //     'msg'   => 'Error in uploading product image',
        //     'status'   => false,                    
        //     'data'  => (object) []
        // ], 200);


    }
    

}
