<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BidanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $desc = "";
        if ($this->bidan_statis) {
            $desc = "Bidan Statis Puskemas {$this->puskesmas->puskesmas_nama}";
        } else {
            $desc = "Bidan Non Statis {$this->kelurahan->kelurahan_nama}";
        }

        if ($this->bidan_pns) {
            $nomor = $this->bidan_nip;
        } else {
            $nomor = $this->bidan_nomor;
        }
        return [
            'desc' => $desc,
            'nomor' => $nomor,
            'data' => parent::toArray($request),
            'user_resource' => new ProfileResource($this->user),
            'reward_resource' => RewardResource::collection($this->reward),
            'links' => [
                'store' => route('bidan.store'),
                'update' => route('bidan.update', $this->bidan_id),
                'destroy' => route('bidan.destroy', $this->bidan_id)
            ]
        ];
    }
}
