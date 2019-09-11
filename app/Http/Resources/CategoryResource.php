<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'nama_kategori' => $this->cat_name,
            'links' =>
                array (
                    'store' => '/api/category',
                    'update' => route('category.update', $this->cat_id),
                    'destroy' => route('category.destroy', $this->cat_id),
                ),
        );
    }
}
