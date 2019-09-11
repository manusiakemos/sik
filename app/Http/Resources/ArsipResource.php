<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArsipResource extends JsonResource
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
            'arsip_id' => $this->arsip_id,
            'kategori' => $this->cat_id,
            'slug' => $this->arsip_slug,
            'kategori_detail' => new CategoryResource($this->category),
            'judul' => $this->arsip_title,
            'label' => $this->category->cat_name . ' Nomor ' . $this->arsip_nomor . ' Tahun ' . $this->arsip_tahun,
            'nomor' => $this->arsip_nomor,
            'hits' => $this->arsip_hits,
            'deskripsi' => $this->arsip_desc ? $this->arsip_desc : '-',
            'tahun' => $this->arsip_date,
            'tanggal' => $this->arsip_tanggal,
            'url_download' => route('arsip.download', $this->arsip_slug),
            'file' => $this->arsip_filename,
            'created_at' => tanggal_indo($this->created_at),
            'tampilkan' => boolean_text($this->arsip_show,"Ya", "Tidak"),
            'links' =>
                array (
                    'store' => '/api/arsip',
                    'update' => route('arsip.update', $this->arsip_id),
                    'destroy' => route('arsip.destroy', $this->arsip_id),
                ),
        );
    }
}
