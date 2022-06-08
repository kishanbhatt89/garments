<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TypeResource extends ResourceCollection
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
                return (object)[
                    'id' => $page->id,
                    'name' => $page->name                    
                ];
            })   
        ];
    }
}
