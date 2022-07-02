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

        return [            
            'msg' => '',
            'status' => true,
            'data' => $this->collection->transform(function($page){

                $variants = collect($page->variations)->sortBy('price');

                $price = $variants->first()->price;
                $discountedPrice = $variants->first()->discounted_price;

                return (object)[
                    'id' => $page->id,
                    'name' => $page->name,
                    'sku' => $page->sku,
                    'brand' => $page->brand,
                    'client' => $page->client->first_name.' '.$page->client->last_name,
                    'store' => $page->store->name,                    
                    'details' => $page->details,
                    'category' => $page->category->name,
                    'subcategory' => $page->subcategory->name,
                    'variation_type' => $page->variation_type,
                    'status' => $page->status,
                    'created_at' => $page->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $page->updated_at->format('Y-m-d H:i:s'),
                    'price' => $price,
                    'discounted_price' => $discountedPrice,
                    'images' => $page->images->transform(function($image){
                        return (object)[                            
                            'image' => $image->image_uploaded_url."/".$image->image,                            
                        ];
                    }),
                    'colors' => $page->colors->transform(function($color){
                        return (object)[
                            'id' => $color->id,                            
                            'code' => $color->color_code,                            
                            'created_at' => $color->created_at->format('Y-m-d H:i:s'),
                            'updated_at' => $color->updated_at->format('Y-m-d H:i:s'),
                        ];
                    }),
                    'variants' => $page->variations->transform(function($variant){
                        return (object)[
                            'id' => $variant->id,
                            'name' => $variant->name, 
                            'price' => $variant->price,                            
                            'discounted_price' => $variant->discounted_price, 
                            'status' => $variant->status,
                            'created_at' => $variant->created_at->format('Y-m-d H:i:s'),
                            'updated_at' => $variant->updated_at->format('Y-m-d H:i:s'),
                        ];
                    }),                    
                ];
            })   
        ];
    }
}
