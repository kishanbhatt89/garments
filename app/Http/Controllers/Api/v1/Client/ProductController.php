<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Client\ChangeProductStatusRequest;
use App\Http\Requests\Api\v1\Client\DeleteProductImageRequest;
use App\Http\Requests\Api\v1\Client\DeleteProductRequest;
use App\Http\Requests\Api\v1\Client\ProductImageRequest;
use App\Http\Requests\Api\v1\Client\ProductRequest;
use App\Http\Requests\Api\v1\Client\ShowProductRequest;
use App\Http\Requests\Api\v1\Client\UpdateProductRequest;
use App\Http\Resources\Api\v1\ProductResource;
use App\Http\Resources\Api\v1\SingleProductResource;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class ProductController extends Controller
{
    public function __construct() {
        $this->middleware(['jwt.auth','is_client_active']);
    }

    public function index(Request $request) {    
        $sort = 'created_at';
        $order = 'desc';        
        
        if ($request->sort == 'name') {
            $sort = 'name';
            $order = 'asc';
        } else if ($request->sort == 'default') {
            $sort = 'created_at';
            $order = 'desc';
        } else if ($request->sort == 'price-htol') {
            $sort = 'price-htol';
            $order = $request->order ?? 'asc';
        } else if ($request->sort == 'price-ltoh') {
            $sort = 'price-ltoh';
            $order = $request->order ?? 'asc';
        } 
        
        if ($request->status == 'all') {
            if ($request->category_id) {       
                $products = $this->getProductsByCategory($request->category_id, $sort, $order);                               
            } else {                
                $products = $this->getProducts($sort, $order);                               
            }
        } else if (!$request->status) {
            if ($request->category_id) {                
                $products = $this->getProductsByCategory($request->category_id, $sort, $order);                 
            } else {                
                $products = $this->getProducts($sort, $order);                       
            }
        } else {
            if ($request->category_id) {
                $products = $this->getProductsByCategoryAndStatus($request->category_id, $request->status, $sort, $order);                
            } else {
                $products = $this->getProductsByStatus($request->status, $sort, $order);                
            }
        }        
        
        $data = $this->paginate($products,1,$request->page);
        
        $finalProducts = (!empty($data)) ? $data->toArray() : array();        
        
        if ($finalProducts && count($finalProducts) > 0) {
            return (new ProductResource($finalProducts))->response()->setStatusCode(200);
        }

        return [            
            'msg' => 'No products found.',
            'status' => false,
            'data' => (object)[]                
        ];        
    }


    public function getProductsByCategory($category_id, $sort, $order) {

        $productsArr = [];

        if ($sort == 'price-htol' || $sort == 'price-ltoh') {
            $products = Product::where('client_id', auth('client')->user()->id)
                            ->where('is_deleted',0)
                            ->where('category_id', $category_id)                            
                            ->get();
        } else {
            $products = Product::where('client_id', auth('client')->user()->id)
                            ->where('is_deleted',0)
                            ->where('category_id', $category_id)                            
                            ->orderBy($sort,$order)
                            ->get();
        }                        

        foreach ($products as $product) {
            
            $productsArr[] = [
                "id" => $product->id,
                "client_id" => $product->client->first_name.' '.$product->client->last_name,
                "store_id" => $product->store->name,
                "sku" => $product->sku,
                "name" => $product->name,
                "details" => $product->details,
                "category" => $product->category->name,
                "subcategory" => $product->subcategory->name,
                "variation_type" => $product->variation_type,
                "brand" => $product->brand,
                "status" => $product->status,
                "created_at" => $product->created_at->diffForHumans(),
                "updated_at" => $product->updated_at->diffForHumans(),
                "price" => $product->variations->sortBy('price')->first()->price,
                "discounted_price" => $product->variations->sortBy('price')->first()->discounted_price,
                "variants" => $product->variations,
                "images" => $product->images,
                "colors" => $product->colors
            ];

            if ($sort == 'price-htol') {
                $productsArr['price'] = $product->variations->sortByDesc('price')->first()->price;
                $productsArr['discounted_price'] = $product->variations->sortByDesc('price')->first()->discounted_price;
            }

            if ($sort == 'price-ltoh') {
                $productsArr['price'] = $product->variations->sortBy('price')->first()->price;
                $productsArr['discounted_price'] = $product->variations->sortBy('price')->first()->discounted_price;
            }

        }    
        
        return $productsArr;

    }

    public function getProductsByStatus($status, $sort, $order) {

        $productsArr = [];

        if ($sort == 'price-htol' || $sort == 'price-ltoh') {
            $products = Product::where('client_id', auth('client')->user()->id)
                            ->where('is_deleted',0)
                            ->where('status', $status)                            
                            ->get();                
        } else {
            $products = Product::where('client_id', auth('client')->user()->id)
                            ->where('is_deleted',0)
                            ->where('status', $status)
                            ->orderBy($sort,$order)
                            ->get();                
        }        

        foreach ($products as $product) {
            
            $productsArr[] = [
                "id" => $product->id,
                "client_id" => $product->client->first_name.' '.$product->client->last_name,
                "store_id" => $product->store->name,
                "sku" => $product->sku,
                "name" => $product->name,
                "details" => $product->details,
                "category" => $product->category->name,
                "subcategory" => $product->subcategory->name,
                "variation_type" => $product->variation_type,
                "brand" => $product->brand,
                "status" => $product->status,
                "created_at" => $product->created_at->diffForHumans(),
                "updated_at" => $product->updated_at->diffForHumans(),
                "price" => $product->variations->sortBy('price')->first()->price,
                "discounted_price" => $product->variations->sortBy('price')->first()->discounted_price,
                "variants" => $product->variations,
                "images" => $product->images,
                "colors" => $product->colors
            ];

            if ($sort == 'price-htol') {
                $productsArr['price'] = $product->variations->sortByDesc('price')->first()->price;
                $productsArr['discounted_price'] = $product->variations->sortByDesc('price')->first()->discounted_price;
            }

            if ($sort == 'price-ltoh') {
                $productsArr['price'] = $product->variations->sortBy('price')->first()->price;
                $productsArr['discounted_price'] = $product->variations->sortBy('price')->first()->discounted_price;
            }

        }    
        
        return $productsArr;

    }

    public function getProductsByCategoryAndStatus($category_id, $status, $sort, $order) {

        $productsArr = [];

        if ($sort == 'price-htol' || $sort == 'price-ltoh') {
            $products = Product::where('client_id', auth('client')->user()->id)
                            ->where('is_deleted',0)
                            ->where('category_id', $category_id)
                            ->where('status', $status)                            
                            ->get();
        } else {
            $products = Product::where('client_id', auth('client')->user()->id)
                            ->where('is_deleted',0)
                            ->where('category_id', $category_id)
                            ->where('status', $status)
                            ->orderBy($sort,$order)
                            ->get();
        }                        

        foreach ($products as $product) {
            
            $productsArr[] = [
                "id" => $product->id,
                "client_id" => $product->client->first_name.' '.$product->client->last_name,
                "store_id" => $product->store->name,
                "sku" => $product->sku,
                "name" => $product->name,
                "details" => $product->details,
                "category" => $product->category->name,
                "subcategory" => $product->subcategory->name,
                "variation_type" => $product->variation_type,
                "brand" => $product->brand,
                "status" => $product->status,
                "created_at" => $product->created_at->diffForHumans(),
                "updated_at" => $product->updated_at->diffForHumans(),
                "price" => $product->variations->sortBy('price')->first()->price,
                "discounted_price" => $product->variations->sortBy('price')->first()->discounted_price,
                "variants" => $product->variations,
                "images" => $product->images,
                "colors" => $product->colors
            ];

            if ($sort == 'price-htol') {
                $productsArr['price'] = $product->variations->sortByDesc('price')->first()->price;
                $productsArr['discounted_price'] = $product->variations->sortByDesc('price')->first()->discounted_price;
            }

            if ($sort == 'price-ltoh') {
                $productsArr['price'] = $product->variations->sortBy('price')->first()->price;
                $productsArr['discounted_price'] = $product->variations->sortBy('price')->first()->discounted_price;
            }

        }    
        
        return $productsArr;

    }

    public function getProducts($sort, $order) {

        $productsArr = [];        

        if ($sort == 'price-htol' || $sort == 'price-ltoh') {
            $products = Product::where('client_id', auth('client')->user()->id)
                            ->where('is_deleted',0)                            
                            ->get();                
        } else {
            $products = Product::where('client_id', auth('client')->user()->id)
                            ->where('is_deleted',0)                            
                            ->orderBy($sort,$order)
                            ->get();                
        }                

        foreach ($products as $product) {
            
            $productsArr[] = [
                "id" => $product->id,
                "client_id" => $product->client->first_name.' '.$product->client->last_name,
                "store_id" => $product->store->name,
                "sku" => $product->sku,
                "name" => $product->name,
                "details" => $product->details,
                "category" => $product->category->name,
                "subcategory" => $product->subcategory->name,
                "variation_type" => $product->variation_type,
                "brand" => $product->brand,
                "status" => $product->status,
                "created_at" => $product->created_at->diffForHumans(),
                "updated_at" => $product->updated_at->diffForHumans(),
                "price" => $product->variations->sortBy('price')->first()->price,
                "discounted_price" => $product->variations->sortBy('price')->first()->discounted_price,
                "variants" => $product->variations,
                "images" => $product->images,
                "colors" => $product->colors
            ];
            
            if ($sort == 'price-htol') {
                $productsArr['price'] = $product->variations->sortByDesc('price')->first()->price;
                $productsArr['discounted_price'] = $product->variations->sortByDesc('price')->first()->discounted_price;
            }

            if ($sort == 'price-ltoh') {
                $productsArr['price'] = $product->variations->sortBy('price')->first()->price;
                $productsArr['discounted_price'] = $product->variations->sortBy('price')->first()->discounted_price;
            }

        }                    
        return $productsArr;

    }

    public function show(ShowProductRequest $request) {

        $product = Product::where('id',$request->id)->where('client_id', auth('client')->user()->id)->first();

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
            $product = Product::where('sku', $request->sku)->where('client_id', auth('client')->user()->id)->first();
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

                    $product->update([
                        'price' => collect($request->variations)->sortBy('price')->first()['price'],
                        'discounted_price' => collect($request->variations)->sortBy('price')->first()['discounted_price']
                    ]);                  
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

                    $product->update([
                        'price' => collect($request->variations)->sortBy('price')->first()['price'],
                        'discounted_price' => collect($request->variations)->sortBy('price')->first()['discounted_price']
                    ]);
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

        $product = Product::where('id',$request->id)->where('client_id', auth('client')->user()->id)->first();

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

    public function changeStatus(ChangeProductStatusRequest $request) {

        if (!$request->has('product_ids') && !$request->has('product_variant_ids')) {
            return response()->json([                
                'msg'   => 'Please add at least one product id or product variant id array',
                'status'   => false,                    
                'data'  => (object) []
            ], 200);        
        }

        if ($request->has('product_ids')) {

            $product_ids = $request->product_ids;

            foreach ($product_ids as $product_id) {
                $product = Product::where('id',$product_id)->where('client_id', auth('client')->user()->id)->first();
                if ($product) {
                    $product->status = $request->status;
                    $product->save();    
                }            
            }

            return response()->json([                
                'msg'   => 'Product status updated successfully!',
                'status'   => true,                    
                'data'  => (object) []
            ], 200);

        }        

        if ($request->has('product_variant_ids')) {

            $product_variant_ids = $request->product_variant_ids;

            foreach ($product_variant_ids as $product_variant_id) {
                $productVariation = ProductVariation::where('id',$product_variant_id)->first();
                if ($productVariation) {
                    $productVariation->status = $request->status;
                    $productVariation->save();    
                }            
            }

            return response()->json([                
                'msg'   => 'Product variant status updated successfully!',
                'status'   => true,                    
                'data'  => (object) []
            ], 200);

        }
        

    }

    public function update(UpdateProductRequest $request) {

        if (auth('client')->user()->is_store_setup == 0) {
            return response()->json([                
                'msg'   => 'Store not setup. Please setup store first.',
                'status'   => false,                    
                'data'  => (object) []
            ], 200);
        }

        // if ($request->sku) {
        //     $product = Product::where('sku', $request->sku)->where('client_id', auth('client')->user()->id)->first();
        //     if ($product) {
        //         return response()->json([                
        //             'msg'   => 'Product with same sku already exists.',
        //             'status'   => false,                    
        //             'data'  => (object) []
        //         ], 200);
        //     }
        // }

        $product = Product::where('id', $request->id)->where('client_id', auth('client')->user()->id)->first();

        if ($product) {

            $productUpdateArr = [];

            if ($request->has('name')) { $productUpdateArr['name'] = $request->name; }
            if ($request->has('details')) { $productUpdateArr['details'] = $request->details; }
            if ($request->has('sku')) { $productUpdateArr['sku'] = $request->sku; }
            if ($request->has('category_id')) { $productUpdateArr['category_id'] = $request->category_id; } 
            if ($request->has('subcategory_id')) { $productUpdateArr['subcategory_id'] = $request->subcategory_id; }
            if ($request->has('brand')) { $productUpdateArr['brand'] = $request->brand; }
            if ($request->has('status')) { $productUpdateArr['status'] = $request->status; }
            if ($request->has('variation_type')) { $productUpdateArr['variation_type'] = $request->variation_type; }            

            $existing_variation_type = $product->variation_type;                        
            
            if ($product->update($productUpdateArr)) {

                $colors = $request->colors;

                if ($colors) {
                    foreach ($colors as $color) {

                        // Delete
                        if (isset($color['flag'])) {
                            
                            $productColor = ProductColor::where('product_id', $product->id)
                                        ->where('id', $color['id'])
                                        ->first();
                            
                            if ($productColor) {
                                $productColor->is_deleted = 1;
                                $productColor->save();
                            }

                        }
                        
                        // Add
                        if (!isset($color['flag'])) {
                            
                            $productColor = new ProductColor();
                            $productColor->product_id = $product->id;
                            $productColor->color_code = $color['color_code'];
                            $productColor->save();                            

                        }

                        // if (isset($color['id'])) {
                        //     $productColor = ProductColor::where('product_id', $product->id)->where('id', $color['id'])->first();
                        //     if (!$productColor) {
                        //         $product->colors()->create([
                        //             'color_code' => $color['color_code'],
                        //         ]);                                
                        //     } else {
                        //         $productColor->color_code = $color['color_code'];
                        //         $productColor->save();
                        //     }
                        // } else {
                        //     $product->colors()->create([
                        //         'color_code' => $color['color_code'],
                        //     ]);
                        // }              
                    }
                }                
                
                if ($existing_variation_type == 'single' && $product->variation_type == 'single') {
                    $variations = $request->variations;
                    
                    if ($variations) {
                        $product->updateDefaultVariation()->first()->update([
                            'price' => $variations[0]['price'],
                            'discounted_price' => $variations[0]['discounted_price'],                            
                            'last_edited_at' => now()
                        ]);
                        $product->update([
                            'price' => collect($request->variations)->sortBy('price')->first()['price'],
                            'discounted_price' => collect($request->variations)->sortBy('price')->first()['discounted_price']
                        ]);
                    }                    
                }

                if ($existing_variation_type == 'multiple' && $product->variation_type == 'multiple') {
                    $variations = $request->variations;
                    if ($variations) {
                        
                        foreach ($variations as $variation) {

                            // Delete Variations
                            if (isset($variation['id']) && isset($variation['flag'])) {
                                dd($product->variations()->where('is_deleted', 0)->get());
                                $product->variations()->where('id', $variation['id'])->first()->update([
                                    'is_deleted' => 1
                                ]);
                                $product->update([
                                    "price" => collect($product->variations()->where('is_deleted', 0))->sortBy('price')->first()['price'],
                                    "discounted_price" => collect($product->variations()->where('is_deleted', 0))->sortBy('price')->first()['discounted_price'],
                                ]);                                
                            }

                            // Update Variations
                            if (isset($variation['id']) && !isset($variation['flag'])) {

                                $updateVariatonArray = [];

                                if (isset($variation['name'])) { $updateVariatonArray['name'] = $variation['name']; }
                                if (isset($variation['price'])) { $updateVariatonArray['price'] = $variation['price']; }
                                if (isset($variation['discounted_price'])) { $updateVariatonArray['discounted_price'] = $variation['discounted_price']; }
                            
                                $updateVariatonArray['is_deleted'] = 0;
                                $updateVariatonArray['last_edited_at'] = now();

                                $product->variations()->where('id', $variation['id'])->first()->update($updateVariatonArray);

                                $product->update([
                                    "price" => collect($product->variations()->where('is_deleted', 0))->sortBy('price')->first()['price'],
                                    "discounted_price" => collect($product->variations()->where('is_deleted', 0))->sortBy('price')->first()['discounted_price'],
                                ]);
                            }

                            // Create Variations
                            if (!isset($variation['id']) && !isset($variation['flag'])) {
                                $pVariation = ProductVariation::where('product_id',$product->id)->where('name',$variation['name'])->where('is_deleted',0)->first();
                                if (!$pVariation) {
                                    $product->variations()->create([
                                        'name' => $variation['name'],
                                        'price' => $variation['price'],
                                        'discounted_price' => $variation['discounted_price'],
                                        'status' => 'active',
                                        'is_deleted' => 0
                                    ]);
                                } else {                                    

                                    if (isset($variation['name'])) { 
                                        $pVariation->name = $variation['name'];
                                    }
                                    if (isset($variation['price'])) { 
                                        $pVariation->price = $variation['price'];    
                                    }
                                    if (isset($variation['discounted_price'])) { 
                                        $pVariation->discounted_price = $variation['discounted_price'];
                                    }

                                    $pVariation->save();
                                }
                                $product->update([
                                    "price" => collect($product->variations()->where('is_deleted', 0))->sortBy('price')->first()['price'],
                                    "discounted_price" => collect($product->variations()->where('is_deleted', 0))->sortBy('price')->first()['discounted_price'],
                                ]);
                            }
                            

                            
                        }
                    }                    
                }

                if ($existing_variation_type == 'single' && $product->variation_type == 'multiple') {

                    $variations = $request->variations;                                    

                    if ($variations) {
                        $product->updateDefaultVariation()->first()->update(['is_deleted' => 1]);
                        foreach ($variations as $variation){                        
                            $productVariation = new ProductVariation();
                            $productVariation->product_id = $product->id;
                            $productVariation->name = $variation['name'];
                            $productVariation->price = $variation['price'];
                            $productVariation->discounted_price = $variation['discounted_price'];
                            $productVariation->status = 'active';                            
                            $productVariation->save();                        
                        }
                        $product->update([
                            "price" => collect($product->variations()->where('is_deleted', 0))->sortBy('price')->first()['price'],
                            "discounted_price" => collect($product->variations()->where('is_deleted', 0))->sortBy('price')->first()['discounted_price'],
                        ]);
                    }
                    
                    

                }

                if ($existing_variation_type == 'multiple' && $product->variation_type == 'single') {

                    $variations = $request->variations;

                    if ($variations) {

                        $eVariations = ProductVariation::where('product_id',$product->id)->where('name','!=','default')->get();

                        if ($eVariations) {
                            foreach ($eVariations as $key => $eVariation) {
                                $eVariation->is_deleted = 1;
                                $eVariation->last_edited_at = now();
                                $eVariation->save();
                            }
                        }
                        
                        $productVariation = new ProductVariation();
                        $productVariation->product_id = $product->id;
                        $productVariation->name = 'default';
                        $productVariation->price = $variations[0]['price'];
                        $productVariation->discounted_price = $variations[0]['discounted_price'];
                        $productVariation->status = 'active';
                        $productVariation->save();

                        $product->update([
                            "price" => collect($product->variations()->where('is_deleted', 0))->sortBy('price')->first()['price'],
                            "discounted_price" => collect($product->variations()->where('is_deleted', 0))->sortBy('price')->first()['discounted_price'],
                        ]);
                               
                    }                                 

                }

                return response()->json([                
                    'msg'   => 'Product details updated successfully.',
                    'status'   => true,                    
                    'data'  => (object) []
                ], 200);
            }            

        }

        return response()->json([                
            'msg'   => 'Error in updating product details.',
            'status'   => false,                    
            'data'  => (object) []
        ], 200);

    }

    public function deleteImage(DeleteProductImageRequest $request) {

        $product = Product::find($request->product_id);

        if ($product) {
            $image = $product->images()->where('id', $request->image_id)->first();
            if ($image) {
                $image->is_deleted = 1;
                $image->save();
                return response()->json([
                    'msg'   => 'Product image deleted successfully.',
                    'status'   => true,
                    'data'  => (object) []
                ], 200);
            }
        }

        return response()->json([                
            'msg'   => 'Error in deleting product image.',
            'status'   => false,                    
            'data'  => (object) []
        ], 200);

    }

    public function delete(DeleteProductRequest $request) {

        $product = Product::find($request->id);

        if ($product) {

            $product->is_deleted = 1;

            if ($product->save()) {

                $product->variations()->update([
                    'is_deleted' => 1
                ]);

                $product->colors()->update([
                    'is_deleted' => 1
                ]);

                $product->images()->update([
                    'is_deleted' => 1
                ]);

                return response()->json([
                    'msg'   => 'Product deleted successfully.',
                    'status'   => true,
                    'data'  => (object) []
                ], 200);

            }   

        }

        return response()->json([                
            'msg'   => 'Error in deleting product.',
            'status'   => false,                    
            'data'  => (object) []
        ], 200);


    }    

    public function paginate($items, $perPage = 1 , $page = null, $options = []) {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

}
