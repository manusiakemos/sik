<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
          'links' =>[
              'store' => route('setting.store'),
              'update' => route('setting.update', $this->setting_id),
              'destroy' => route('setting.destroy', $this->setting_id)
          ]
        ];
    }
}
