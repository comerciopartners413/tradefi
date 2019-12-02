<?php

namespace TradefiUBA\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Gender extends JsonResource
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
            'id'   => $this->GenderRef,
            'name' => $this->Gender,
        ];
    }
}
