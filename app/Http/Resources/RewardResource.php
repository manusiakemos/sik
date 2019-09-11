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
            'tanggal_reward' => tanggal_indo($this->reward_date, true, false),
            'links' => [
                'store' => route('reward.store'),
                'update' => route('reward.update', $this->reward_id),
                'destroy' => route('reward.destroy', $this->reward_id),
            ]
        ];
    }
}
