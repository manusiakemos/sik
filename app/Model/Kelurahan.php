<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = "_kelurahan";
    protected $primaryKey = "kelurahan_id";

    public function scopeTabalong($query)
    {
        return $query->select(["_kelurahan.*", "kecamatan_nama"])
            ->join("_kecamatan", "_kecamatan.kecamatan_id", "=", "_kelurahan.kecamatan_id")
            ->where("_kecamatan.kabupaten_id", 6309);
    }
}
