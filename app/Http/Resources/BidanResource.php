<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BidanResource extends JsonResource
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
            'data' => parent::toArray($request),
            'links' => [
                'store' => route('bidan.store'),
                'update' => route('bidan.update', $this->bidan_id),
                'destroy' => route('bidan.destroy', $this->bidan_id)
            ]
        ];
    }
}
