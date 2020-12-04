<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'author';
    protected $fillable = ['user_id', 'deskripsi', 'kode'];
    protected $with = ['user'];

    public static function boot() {
        parent::boot();
        static::saving(function ($model) {
            $model->kode = Str::random(10);
        });
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
