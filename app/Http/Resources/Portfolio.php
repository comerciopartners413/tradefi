<?php

namespace TradefiUBA\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Portfolio extends JsonResource
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
            'product'  => $this->Product,
            'quantity' => $this->Quantity,

        ];
    }
}
