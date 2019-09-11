<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KelurahanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $str = "Desa {$this->kelurahan_nama} Kecamatan {$this->kecamatan_nama}";
        return array(
            'value' => $this->kelurahan_id,
            'text' => ucwords(strtolower($str)),
        );
    }
}
