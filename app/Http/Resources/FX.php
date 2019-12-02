<?php

namespace TradefiUBA\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FX extends JsonResource
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
            'pair'     => $this->pairs,
            'previous' => $this->previous,
            'current'  => $this->current,
            'as_at'    => (string) $this->updated_at,
        ];
    }
}
