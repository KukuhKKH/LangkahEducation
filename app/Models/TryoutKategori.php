<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TryoutKategori extends Model
{
    protected $table = "tryout_kategori";
    protected $fillable = ['user_id', 'nama', 'slug', 'image', 'deskripsi'];

    public static function boot() {
        parent::boot();
        static::saving(function ($model) {
            $model->slug = Str::slug($model->nama);
        });
    }

    public function paket() {
        return $this->hasMany('App\Models\TryoutPaket');
    }

    public function soal() {
        return $this->hasMany('App\Models\TryoutSoal');
    }

}
