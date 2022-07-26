<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {                
        $responseData = [];
        $productData = [];

        if (isset($this['data']) && count($this['data']) > 0) {            

            $variationResponseArr = $imageResponseArr = $colorResponseArr = [];
            
            foreach ($this['data']  as $key => $product) {      

                $price = $discountedPrice = 0.0;
                $imageURL = '';                                
                
                if (isset($product['variations']) && count($product['variations']) > 0) {
                    
                    $price = isset($product['variations'][0]['price']) ? number_format((float)$product['variations'][0]['price'], 2, '.', '') : 0.0;
                    $discountedPrice = isset($product['variations'][0]['discounted_price'])? number_format((float)$product['variations'][0]['discounted_price'], 2, '.', '') : 0.0;

                    foreach ($product['variations'] as $variation) {

                        $variationResponseArr[] = [
                            'id' => $variation['id'],
                            'name' => $variation['name'], 
                            'price' => number_format((float)$variation['price'], 2, '.', ''),                            
                            'discounted_price' => number_format((float)$variation['discounted_price'], 2, '.', ''), 
                            'status' => $variation['status'],
                            'created_at' => $variation['created_at'],
                            'updated_at' => $variation['updated_at'],
                        ];
                    }                                        

                }
                dd($product['images']);
                if (isset($product['images']) && count($product['images']) > 0) {

                    $url = isset($images['images'][0]['image_uploaded_url']) ? $images['images'][0]['image_uploaded_url'] : '';
                    $name = isset($images['images'][0]['image']) ? $images['images'][0]['image'] : '';                        

                    if ($url !== '' && $name !== '') {

                        $imageURL = $url.'/'.$name;

                    }

                    foreach ($product['images'] as $image) {

                        $imageResponseArr[] = [
                            'id' => $image['id'],
                            'image' => $image['image_uploaded_url']."/".$image['image'],
                        ];

                    }

                }

                dd($imageURL);

                if (isset($product['colors']) && count($product['colors']) > 0) {

                    foreach ($product['colors'] as $color) {

                        $colorResponseArr[] = [
                            'id' => $color['id'],
                            'code' => $color['color_code'], 
                            'created_at' => $color['created_at'],
                            'updated_at' => $color['updated_at'],
                        ];

                    }                    

                }

                $productData[$key] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'sku' => $product['sku'] ? $product['sku'] : '',
                    'brand' => $product['brand'] ? $product['brand'] : '',
                    'client' => isset($product['client']) ? $product['client']['first_name'].' '.$product['client']['last_name'] : '',
                    'store' => isset($product['store']) ? $product['store']['name'] : '',
                    'details' => $product['details'] ? $product['details'] : '',
                    'category' => isset($product['category']) ? $product['category']['name'] : '',
                    'subcategory' => isset($product['subcategory']) ? $product['subcategory']['name'] : '',
                    'variation_type' => $product['variation_type'] ? $product['variation_type'] : '',
                    'status' => $product['status'],
                    'image' => $imageURL,
                    'price' => number_format((float)$price, 2, '.', ''),
                    'discounted_price' => number_format((float)$discountedPrice, 2, '.', ''),                    
                    'created_at' => $product['created_at'],
                    'updated_at' => $product['updated_at'],
                    'variants' => $variationResponseArr,
                    'images' => $imageResponseArr,
                    'colors' => $colorResponseArr,
                    
                ];                

            }

        }   

        $responseData['products'] = count($productData) > 0 ? $productData : [];
        
        $responseData['pagination'][] = [
            'current_page' => $this['current_page'],
            'first_page_url' => $this['first_page_url'],
            'from' => $this['from'],
            'next_page_url' => $this['next_page_url'],
            'per_page' => $this['per_page'],
            'prev_page_url' => $this['prev_page_url'],
            'to' => $this['to']
        ];            

        return [            
            'msg' => '',
            'status' => true,
            'data' => $responseData,
        ];
        
        /*
        return [            
            'msg' => '',
            'status' => true,
            'data' => $this->collection->transform(function($page){

                // $price = 0.0;
                // $discountedPrice = 0.0;

                // if ($page->variations) {
                //     $variants = collect($page->variations)->where('is_deleted',0)->sortBy('price');
                    
                //     if (!$variants->isEmpty()) {
                //         $price = isset($variants->first()->price) ? number_format((float)$variants->first()->price, 2, '.', '') : 0.0;
                //         $discountedPrice = isset($variants->first()->discounted_price )? number_format((float)$variants->first()->discounted_price, 2, '.', '') : 0.0;
                //     }                    
                // }             

                $imageURL = '';
                
                if ($page->images) {
                    $images = collect($page->images)->where('is_deleted',0)->sortBy('created_at');
                    if ($images) {
                        $url = isset($images->first()->image_uploaded_url) ? $images->first()->image_uploaded_url : '';
                        $name = isset($images->first()->image) ? $images->first()->image : '';                        
                        if ($url !== '' && $name !== '') {
                            $imageURL = $url.'/'.$name;
                        }                        
                    }
                }

                $variants = collect($page->variations)->where('is_deleted',0);
                $variantResponseArr = [];
                foreach ($variants as $variant) {
                    $variantResponseArr[] = [
                        'id' => $variant->id,
                        'name' => $variant->name, 
                        'price' => number_format((float)$variant->price, 2, '.', ''),                            
                        'discounted_price' => number_format((float)$variant->discounted_price, 2, '.', ''), 
                        'status' => $variant->status,
                        'created_at' => $variant->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $variant->updated_at->format('Y-m-d H:i:s'),
                    ];
                }

                $colors = collect($page->colors)->where('is_deleted',0);
                $colorResponseArr = [];
                foreach ($colors as $color) {
                    $colorResponseArr[] = [
                        'id' => $color->id,
                        'code' => $color->color_code, 
                        'created_at' => $color->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $color->updated_at->format('Y-m-d H:i:s'),
                    ];
                }

                $images = collect($page->images)->where('is_deleted',0);
                $imageResponseArr = [];
                foreach ($images as $image) {
                    $imageResponseArr[] = [
                        'id' => $image->id,
                        'image' => $image->image_uploaded_url."/".$image->image,
                    ];
                }

                return (object)[
                    'id' => $page->id,
                    'name' => $page->name,
                    'sku' => $page->sku ? $page->sku : '',
                    'brand' => $page->brand ? $page->brand : '',
                    'client' => $page->client->first_name.' '.$page->client->last_name,
                    'store' => $page->store->name,                    
                    'details' => $page->details,
                    'category' => $page->category->name,
                    'subcategory' => $page->subcategory->name,
                    'variation_type' => $page->variation_type,
                    'status' => $page->status,
                    'image' => $imageURL,
                    'created_at' => $page->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $page->updated_at->format('Y-m-d H:i:s'),
                    'price' => number_format((float)$price, 2, '.', ''),                    
                    'discounted_price' => number_format((float)$discountedPrice, 2, '.', ''),
                    'images' => $imageResponseArr,
                    'colors' => $colorResponseArr,
                    'variants' => $variantResponseArr,                   
                ];
            })   
        ];
        */
    }
}
