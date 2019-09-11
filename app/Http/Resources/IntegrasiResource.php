<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IntegrasiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array (
            'idData' => "$this->arsip_id",
            'tahun_pengundangan' => "$this->arsip_tahun",
            'tanggal_pengundangan' => "$this->arsip_date",
            'jenis' => "{$this->category->cat_name}",
            'noPeraturan' =>" $this->arsip_nomor",
            'judul' => "$this->arsip_title",
            'fileDownload' => "$this->arsip_filename",
            'urlDownload' => route('arsip.download', $this->arsip_slug),
            'operasi' => '4',
            'display' => '1',
        );
    }
}
