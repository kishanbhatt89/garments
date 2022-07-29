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
use \Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    public function __construct() {

        $this->middleware(['jwt.auth','is_client_active']);

    }

    public function index(Request $request) {    

        $sort = 'created_at';
        $order = 'desc';

        $vSort = 'price';
        $vOrder = 'asc';
        
        if ($request->sort == 'name') {
            $sort = 'name';
            $order = 'asc';
        } else if ($request->sort == 'price-htol') {            
            $vSort = 'price';
            $vOrder = 'desc';
        } else if ($request->sort == 'price-ltoh') {            
            $vSort = 'price';
            $vOrder = 'asc';
        } else if ($request->sort == 'default') {
            $sort = 'created_at';
            $order = 'desc';
        }       
        
        if ($request->status == 'all') {

            if ($request->category_id) {       

                $products = Product::with([
                                'variations' => function($query) use ($vSort, $vOrder) {
                                    $query->where('is_deleted',0)->orderBy($vSort,$vOrder);
                                },
                                'images' => function($query) {
                                    $query->where('is_deleted',0)->orderBy('created_at','desc');
                                },
                                'colors' => function($query) {
                                    $query->where('is_deleted',0)->orderBy('created_at','desc');
                                },
                                'client',
                                'store',
                                'category',
                                'subcategory'
                            ])
                            ->where('client_id', auth('client')->user()->id)
                            ->where('category_id', $request->category_id)                            
                            ->where('is_deleted',0)
                            ->orderBy($sort,$order);                

            } else {

                $products = Product::with([
                                'variations' => function($query) use ($vSort, $vOrder) {
                                    $query->where('is_deleted',0)->orderBy($vSort,$vOrder);
                                },
                                'images' => function($query) {
                                    $query->where('is_deleted',0)->orderBy('created_at','desc');
                                },
                                'colors' => function($query) {
                                    $query->where('is_deleted',0)->orderBy('created_at','desc');
                                },
                                'client',
                                'store',
                                'category',
                                'subcategory'
                            ])
                            ->where('client_id', auth('client')->user()->id)                                                        
                            ->where('is_deleted',0)
                            ->orderBy($sort,$order);                

            }

        } else if (!$request->status) {

            if ($request->category_id) {                

                $products = Product::with([
                                'variations' => function($query) use ($vSort, $vOrder) {
                                    $query->where('is_deleted',0)->orderBy($vSort,$vOrder);
                                },
                                'images' => function($query) {
                                    $query->where('is_deleted',0)->orderBy('created_at','desc');
                                },
                                'colors' => function($query) {
                                    $query->where('is_deleted',0)->orderBy('created_at','desc');
                                },
                                'client',
                                'store',
                                'category',
                                'subcategory'
                            ])
                            ->where('client_id', auth('client')->user()->id)
                            ->where('category_id', $request->category_id)                            
                            ->where('is_deleted',0)
                            ->orderBy($sort,$order);                 

            } else {
                
                $products = Product::with([
                                'variations' => function($query) use ($vSort, $vOrder) {
                                    $query->where('is_deleted',0)->orderBy($vSort,$vOrder);
                                },
                                'images' => function($query) {
                                    $query->where('is_deleted',0)->orderBy('created_at','desc');
                                },
                                'colors' => function($query) {
                                    $query->where('is_deleted',0)->orderBy('created_at','desc');
                                },
                                'client',
                                'store',
                                'category',
                                'subcategory'
                            ])
                            ->where('client_id', auth('client')->user()->id)                                                        
                            ->where('is_deleted',0)
                            ->orderBy($sort,$order); 

            }

        } else {

            if ($request->category_id) {

                $products = Product::with([
                                'variations' => function($query) use ($vSort, $vOrder) {
                                    $query->where('is_deleted',0)->orderBy($vSort,$vOrder);
                                },
                                'images' => function($query) {
                                    $query->where('is_deleted',0)->orderBy('created_at','desc');
                                },
                                'colors' => function($query) {
                                    $query->where('is_deleted',0)->orderBy('created_at','desc');
                                },
                                'client',
                                'store',
                                'category',
                                'subcategory'
                            ])
                            ->where('client_id', auth('client')->user()->id)
                            ->where('category_id', $request->category_id)
                            ->where('status',$request->status)
                            ->where('is_deleted',0)
                            ->orderBy($sort,$order); 

            } else {

                $products = Product::with([
                                'variations' => function($query) use ($vSort, $vOrder) {
                                    $query->where('is_deleted',0)->orderBy($vSort,$vOrder);
                                },
                                'images' => function($query) {
                                    $query->where('is_deleted',0)->orderBy('created_at','desc');
                                },
                                'colors' => function($query) {
                                    $query->where('is_deleted',0)->orderBy('created_at','desc');
                                },
                                'client',
                                'store',
                                'category',
                                'subcategory'
                            ])
                            ->where('client_id', auth('client')->user()->id)                            
                            ->where('status',$request->status)
                            ->where('is_deleted',0)
                            ->orderBy($sort,$order);                                

            }
        }        

        $data = $products->paginate(4);

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
                    }                    
                }

                if ($existing_variation_type == 'multiple' && $product->variation_type == 'multiple') {
                    $variations = $request->variations;
                    if ($variations) {
                        
                        foreach ($variations as $variation) {

                            // Delete Variations
                            if (isset($variation['id']) && isset($variation['flag'])) {
                                $product->variations()->where('id', $variation['id'])->first()->update([
                                    'is_deleted' => 1
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
    

}
