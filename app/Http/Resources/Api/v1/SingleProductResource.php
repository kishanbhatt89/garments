<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {        

        $variants = collect($this->variations)->where('is_deleted',0)->sortBy('price');

        $price = $variants->first()->price;
        $discountedPrice = $variants->first()->discounted_price;

        $imageURL = '';
        
        if ($this->images) {
            $images = collect($this->images)->sortBy('created_at');
            if ($images) {
                $url = isset($images->first()->image_uploaded_url) ? $images->first()->image_uploaded_url : '';
                $name = isset($images->first()->image) ? $images->first()->image : '';                        
                if ($url !== '' && $name !== '') {
                    $imageURL = $url.'/'.$name;
                }                        
            }
        }

        $variants = collect($this->variations)->where('is_deleted',0);
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

        return [            
            'msg' => '',
            'status' => true,
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'sku' => $this->sku ? $this->sku : '',
                'brand' => $this->brand ? $this->brand : '',
                'client' => $this->client->first_name.' '.$this->client->last_name,
                'store' => $this->store->name,                
                'details' => $this->details,
                'category' => $this->category->name,
                'subcategory' => $this->subcategory->name,
                'variation_type' => $this->variation_type,
                'status' => $this->status,
                'image' => $imageURL,
                'price' => $price,
                'discounted_price' => $discountedPrice,
                'created_at' => $this->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
                'images' => $this->images->transform(function($image){
                    return (object)[                            
                        'image' => $image->image_uploaded_url."/".$image->image,                            
                    ];
                }),
                'colors' => $this->colors->transform(function($color){
                    return (object)[
                        'id' => $color->id,                            
                        'code' => $color->color_code,                            
                        'created_at' => $color->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $color->updated_at->format('Y-m-d H:i:s'),
                    ];
                }),
                'variants' => $variantResponseArr,                    
            ]        
        ];
    }
}
