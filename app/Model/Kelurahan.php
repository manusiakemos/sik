<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = "_kelurahan";
    protected $primaryKey = "kelurahan_id";

    public function scopeTabalong($query)
    {
        if(auth()->check() && auth()->user()->user_level == 'puskesmas'){
            $user= auth()->user();
            $pkm = Puskesmas::find($user->puskesmas_id);
            $kec = Kecamatan::find($pkm->kecamatan_id);
            return $query->select(["_kelurahan.*", "kecamatan_nama"])
                ->join("_kecamatan", "_kecamatan.kecamatan_id", "=", "_kelurahan.kecamatan_id")
                ->where("_kecamatan.kecamatan_id", $kec->kecamatan_id);
        }else{
            return $query->select(["_kelurahan.*", "kecamatan_nama"])
                ->join("_kecamatan", "_kecamatan.kecamatan_id", "=", "_kelurahan.kecamatan_id")
                ->where("_kecamatan.kabupaten_id", 6309);
        }
    }
}
