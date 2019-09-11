<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PregnancyProcess extends Model
{
    protected $table = "_pregnancy_process";

    protected $primaryKey = "pp_id";

    public function detail()
    {
        return $this->hasMany(PregnancyProcessDetail::class, 'pp_id', 'pp_id');
    }
}
