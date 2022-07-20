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
        
        $price = $discountedPrice = floatval(0.0);
        if (!$variants->isEmpty()) {
            $price = isset($variants->first()->price) ? floatval(number_format((float)$variants->first()->price, 2, '.', '')) : 0.0;
            $discountedPrice = isset($variants->first()->discounted_price)? floatval(number_format((float)$variants->first()->discounted_price, 2, '.', '')) : 0.0;
        }        

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
                'price' => floatval(number_format((float)$variant->price, 2, '.', '')),                            
                'discounted_price' => floatval(number_format((float)$variant->discounted_price, 2, '.', '')), 
                'status' => $variant->status,
                'created_at' => $variant->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $variant->updated_at->format('Y-m-d H:i:s'),
            ];
        }

        $colors = collect($this->colors)->where('is_deleted',0);
        $colorResponseArr = [];
        foreach ($colors as $color) {
            $colorResponseArr[] = [
                'id' => $color->id,
                'code' => $color->color_code, 
                'created_at' => $color->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $color->updated_at->format('Y-m-d H:i:s'),
            ];
        }

        $images = collect($this->images)->where('is_deleted',0);
        $imageResponseArr = [];
        foreach ($images as $image) {
            $imageResponseArr[] = [
                'id' => $image->id,
                'image' => $image->image_uploaded_url."/".$image->image,
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
                'price' => floatval(number_format((float)$price, 2, '.', '')),
                'discounted_price' => floatval(number_format((float)$discountedPrice, 2, '.', '')),
                'created_at' => $this->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
                'images' => $imageResponseArr,
                'colors' => $colorResponseArr,
                'variants' => $variantResponseArr,                    
            ]        
        ];
    }
}
