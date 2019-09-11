<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PuskesmasResource extends JsonResource
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
                'store' => route('puskesmas.store'),
                'update' => route('puskesmas.update', $this['puskesmas_id']),
                'destroy' => route('puskesmas.destroy', $this['puskesmas_id']),
            ]
        ];
    }
}
