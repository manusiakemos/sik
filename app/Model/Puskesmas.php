<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Puskesmas extends Model
{
    protected $table = '_puskesmas';

    protected $primaryKey ='puskesmas_id';

    use SoftDeletes;

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'kecamatan_id');
    }
}
