<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = "_setting";

    protected $primaryKey = "setting_id";

    public $timestamps = false;
}
