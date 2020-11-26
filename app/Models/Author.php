<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'author';
    protected $fillable = ['user_id'];
    protected $with = ['user'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
