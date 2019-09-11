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
            'detail' => PregnancyProcessDetailResource::collection($this->detail),
            'links' => [
                'update' => route('pregnancyprocess.update', $this->pp_id),
                'destroy' => route('pregnancyprocess.destroy', $this->pp_id)
            ]
        ];
    }
}
