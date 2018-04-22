<?php

namespace App\Http\Resources\ProductRsc;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'OwnerID'=>$this->user_id,
            'description' =>$this->detail,
            'stock'=>$this->stock,
            'price'=>$this->price,
            'image'=>url('/images') .'/'.$this->img,
            'discount'=>$this->discount,
            'totalPrice'=>$this->discount >0 ? round((1-($this->discount/100))*$this->price,2):$this->price,
            'rate'=> $this->reviews()->count() > 0 ?round($this->reviews()->sum('star')/$this->reviews()->count(),2):"No Rating",
            'href'=>[
                'link'=>route('reviews.index',$this->id)
            ]
        ];
    }
}
