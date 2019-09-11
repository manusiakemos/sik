<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryBerita extends Model
{
    protected $table = "category_berita";

    protected $primaryKey = "cb_id";

    use SoftDeletes;
}
