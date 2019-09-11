<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bidan extends Model
{
    protected $table = "_bidan";

    protected $primaryKey = "bidan_id";

    use SoftDeletes;

    public function scopeJoinAll($query)
    {
        return $query->leftJoin('_puskesmas', '_puskesmas.puskesmas_id', '=', '_bidan.puskesmas_id')
            ->leftJoin('_kelurahan', '_kelurahan.kelurahan_id', '=', '_bidan.kelurahan_id');

    }

    public function reward()
    {
        return $this->hasMany(Reward::class, 'bidan_id', 'bidan_id');
    }

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class, 'puskesmas_id', 'puskesmas_id')->withTrashed();
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id', 'kelurahan_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'bidan_id', 'bidan_id')->withTrashed();
    }
}
