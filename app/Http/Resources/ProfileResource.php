<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->user_avatar
            ? $avatar = asset("/assets/img/avatar/$this->user_avatar")
            : $avatar = asset('/assets/img/avatar/avatar-1.png');

        return array(
            'id' => $this->user_id,
            'name' => $this->username,
            'username' => $this->username,
            'password' => '',
            'password_confirmation' => '',
            'avatar' => $avatar,
            'api_token' => $this->api_token,
            'role' => $this->user_level,
            'links' =>[
                'update' => route('profile.update'),
                'edit' => route('profile.edit'),
                'avatar' => route('profile.avatar'),
            ]
        );
    }
}
