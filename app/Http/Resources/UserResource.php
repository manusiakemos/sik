<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->avatar
            ? $avatar = asset("/assets/img/avatar//$this->avatar")
            : $avatar = asset('/assets/img/avatar/avatar-1.png');
        return array(
            'id' => $this->id,
            'puskesmas_id' => $this->puskesmas_id,
            'bidan_id' => $this->bidan_id,
            'username' => $this->username,
            'avatar' => $avatar,
            'api_token' => $this->api_token,
            'role' => $this->user_level,
            'password' => "",
            'password_confirmation' => "",
            'links' => [
                "store" => route("user.store"),
                "update" => route("user.update", $this->id),
                "destroy" => route("user.destroy", $this->id),
            ]
        );
    }
}
