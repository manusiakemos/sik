<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PregnancyProcessDetailResource extends JsonResource
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
            'data' =>  parent::toArray($request),
            'links' => [
                'update' => route('pregnancyprocessdetail.update', $this->ppd_id)
            ]
        ];
    }
}
