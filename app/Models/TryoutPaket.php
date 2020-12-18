<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class TryoutPaket extends Model
{
    protected $table = "tryout_paket";
    protected $fillable = ['user_id', 'nama', 'slug','deskripsi', 'image', 'tgl_awal', 'tgl_akhir', 'status', 'poin_1', 'poin_2', 'poin_3', 'poin_4', 'url_youtube_saintek', 'url_youtube_soshum'];

    public static function boot() {
        parent::boot();
        static::saving(function ($model) {
            $model->slug = Str::slug($model->nama);
        });
    }

    public function scopeFindSlug($query, $slug) {
        return $query->where('slug', $slug)->firstOrFail();
    }

    public function soal() {
        return $this->hasMany('App\Models\TryoutSoal');
    }

    public function hasil() {
        return $this->hasMany('App\Models\TryoutHasil');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function temp() {
        return $this->hasMany('App\Models\TempProdi', 'paket_id');
    }
}
