<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $table = "category";
    protected $primaryKey = "cat_id";

    use SoftDeletes;
}
