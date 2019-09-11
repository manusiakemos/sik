<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PregnancyProcessDetail extends Model
{
    protected $table = "_process_detail";

    protected $primaryKey = "ppd_id";

    public function pregnancyProcess()
    {
        return $this->belongsTo(PregnancyProcess::class, 'pp_id', 'pp_id');
    }
}
