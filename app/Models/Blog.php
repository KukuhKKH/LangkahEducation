<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blog';
    protected $fillable = ['user_id', 'judul', 'isi', 'foto', 'slug', 'tags'];

    public static function boot() {
        parent::boot();
        static::saving(function ($model) {
            $model->slug = Str::slug($model->judul);
        });
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function kategori() {
        return $this->belongsToMany("App\Models\Kategori", "blog_kategori");
    }
}
