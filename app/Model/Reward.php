<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $table = "_reward";
    protected $primaryKey = "reward_id";

    public function bidan()
    {
        return $this->belongsTo(Bidan::class, 'bidan_id', 'bidan_id')->withTrashed();
    }
}
