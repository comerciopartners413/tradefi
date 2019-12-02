<?php

namespace TradefiUBA\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Macro extends JsonResource
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
            'id'       => $this->id,
            'name'     => $this->name,
            'previous' => $this->previous,
            'current'  => $this->current,
            'as_at'    => (string) $this->as_at,
        ];
    }
}
