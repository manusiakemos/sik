<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PregnancyProcessResource extends JsonResource
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
            'data' => [
                'pp_id' => $this->pp_id,
                'pp_code' => $this->pp_code,
                'pp_nokk' => $this->pp_nokk,
                'pp_noktp_ibu' => $this->pp_noktp_ibu,
                'pp_nama_ibu' => $this->pp_nama_ibu,
                'pp_goldarah_ibu' => $this->pp_goldarah_ibu,
                'pp_imagektp_ibu' => $this->pp_imagektp_ibu,
                'pp_noktp_ayah' => $this->pp_noktp_ayah,
                'pp_nama_ayah' => $this->pp_nama_ayah,
                'pp_imagektp_ayah' => $this->pp_imagektp_ayah,
                'pp_nama_anak' => $this->pp_nama_anak,
                'pp_jk_anak' => $this->pp_jk_anak,
                'pp_anak_ke' => $this->pp_anak_ke,
                'pp_imagekk' => $this->pp_imagekk,
                'pp_imagebukunikah' => $this->pp_imagebukunikah,
                'pp_alamat_paket' => $this->pp_alamat_paket,
                'pp_status' => $this->pp_status,
                'created_by' => $this->created_by,
                'created_at' => $this->created_at,
                'update_born_by' => $this->update_born_by,
                'update_to_born' => $this->update_to_born,
                'update_to_done' => $this->update_to_done,
                'update_to_send' => $this->update_to_send,
            ],
            'mod' => [
                'created_at' => tanggal_indo($this->created_at),
                'update_to_born' => tanggal_indo($this->update_to_born),
                'update_to_done' => tanggal_indo($this->update_to_done),
                'update_to_send' => tanggal_indo($this->update_to_send),
                'show_detail' => false,
                'show_riwayat' => false,
                'show_edit_status' => false,
                'foto_kk' => $this->pp_imagekk
                    ? asset('uploads/'.$this->pp_imagekk)
                    : asset('assets/img/news/img01.jpg'),
                'buku_nikah' => $this->pp_imagebukunikah
                    ? asset('uploads/'.$this->pp_imagebukunikah)
                    : asset('assets/img/news/img01.jpg'),
                'ktp_ayah' => $this->pp_imagektp_ayah
                    ? asset('uploads/'.$this->pp_imagektp_ayah)
                    : asset('assets/img/news/img01.jpg'),
                'ktp_ibu' => $this->pp_imagektp_ibu
                    ? asset('uploads/'.$this->pp_imagektp_ibu)
                    : asset('assets/img/news/img01.jpg'),
            ],
            'detail' => PregnancyProcessDetailResource::collection($this->detail),
            'bidan' => $this->bidan,
            'links' => [
                'update' => route('pregnancyprocess.update', $this->pp_id),
                'destroy' => route('pregnancyprocess.destroy', $this->pp_id)
            ]
        ];
    }
}
