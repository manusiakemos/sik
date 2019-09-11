<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryBeritaResource extends JsonResource
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
            'nama_kategori' => $this->cb_name,
            'links' =>
                array (
                    'store' => '/api/category-berita',
                    'update' => route('category-berita.update', $this->cb_id),
                    'destroy' => route('category-berita.destroy', $this->cb_id),
                ),
        );
    }
}
