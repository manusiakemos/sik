<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RewardResource extends JsonResource
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
            'data' => parent::toArray($request),
            'links' => [
                'update' => route('reward.update', $this->reward_id)
            ],
            'tanggal_reward' => $this->updated_at
                ? tanggal_indo($this->updated_at, true, true)
                : tanggal_indo($this->created_at, true, true)
        ];
    }
}
