<?php

namespace App\Http\Resources\ProductRsc;

use Illuminate\Http\Resources\Json\Resource;

class ProductCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'description' =>$this->detail,
            'discount'=>$this->discount,
            'rate'=> $this->reviews()->count() > 0 ? round($this->reviews()->sum('star')/$this->reviews()->count(),2):"No Rating",
            'href'=>[
                'link'=>route('products.show',$this->id)
            ]
        ];
    }
}
