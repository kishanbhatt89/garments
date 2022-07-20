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

                $price = 0.0;
                $discountedPrice = 0.0;

                if ($page->variations) {
                    $variants = collect($page->variations)->where('is_deleted',0)->sortBy('price');
                    
                    if (!$variants->isEmpty()) {
                        dd($variants->first(), $variants->first()->price);
                        $price = isset($variants->first()->price) ? round($variants->first()->price,2) : 0.0;
                        $discountedPrice = isset($variants->first()->discounted_price )? round($variants->first()->discounted_price,2) : 0.0;
                    }                    
                }             

                $imageURL = '';
                
                if ($page->images) {
                    $images = collect($page->images)->sortBy('created_at');
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
                        'price' => $variant->price,                            
                        'discounted_price' => $variant->discounted_price, 
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
                    'price' => $price,
                    'discounted_price' => $discountedPrice,
                    'images' => $imageResponseArr,
                    'colors' => $colorResponseArr,
                    'variants' => $variantResponseArr,                   
                ];
            })   
        ];
    }
}
