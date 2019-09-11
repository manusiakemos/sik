<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berita extends Model
{
    protected $table = "berita";

    protected $primaryKey = "berita_id";

    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }

    public function category()
    {
        return $this->belongsTo(CategoryBerita::class, 'cb_id', 'cb_id')->withTrashed();
    }
}
