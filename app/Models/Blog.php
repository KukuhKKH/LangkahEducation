<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blog';
    protected $fillable = ['user_id', 'slug', 'judul', 'isi', 'foto', 'slug', 'tags','status'];

    public static function boot() {
        parent::boot();
        static::saving(function ($model) {
            $model->slug = Str::slug($model->judul);
        });
    }

    public function scopeFindSlug($query, $slug) {
        return $query->where('slug', $slug)->firstOrFail();
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function kategori() {
        return $this->belongsToMany("App\Models\Kategori", "blog_kategori");
    }

    public function komentar() {
        return $this->hasMany('App\Models\KomentarBlog');
    }

    public function like() {
        return $this->belongsToMany('App\Models\User', 'blog_like', 'blog_id');
    }
}
