<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {        
        return [
            'status_code' => 200,
            'msg' => 'Store created successfully!',
            'status' => true,
            'data' => [                
                'name' => $this->name,
                'type' => $this->type->name,
                'description' => $this->description,
                'address' => $this->address,
                'city' => $this->city,
                'state' => $this->state->name,
                'zipcode' => $this->zipcode,
                'gst' => $this->gst
            ]
        ];
    }
}
