<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $fillable = ['user_id', 'nama', 'slug', 'foto'];

    public static function boot() {
        parent::boot();
        static::saving(function ($model) {
            $model->slug = Str::slug($model->nama);
        });
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function blog() {
        return $this->belongsToMany("App\Models\Blog", "blog_kategori");
    }
}
