<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarBlog extends Model
{
    protected $table = 'komentar_blog';
    protected $fillable = ['blog_id', 'user_id', 'komentar'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function blog() {
        return $this->belongsTo('App\Models\Blog');
    }
}
