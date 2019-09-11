<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class BeritaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'berita_id' => $this->berita_id,
            'user_id' => $this->user_id,
            'cb_id' => $this->cb_id,
            'status' => boolean_text($this->berita_aktif),
            'judul' => $this->berita_judul,
            'url' => url('/berita/' . $this->berita_url),
            'slug' => "/berita/" . $this->berita_url,
            'plain_url' => $this->berita_url,
            'file' => '',
            'gambar' => asset('assets/img/news/' . $this->berita_gambar),
            'content' => $this->berita_isi,
            'short_content' => Str::limit($this->berita_isi, 100),
            'dikunjungi' => $this->berita_hit,
            'created_at' => tanggal_indo($this->created_at),
            'updated_at' => tanggal_indo($this->updated_at),
            'category' => [
                'nama' => $this->category->cb_name
            ],
            'creator' => [
                'nama' => $this->user->name
            ],
            'links' => [
                'store' => route('berita.create'),
                'update' => route('berita.update', $this->berita_id),
                'show' => route('berita.show', $this->berita_id),
                'destroy' => route('berita.destroy', $this->berita_id)
            ]
        ];
    }
}
