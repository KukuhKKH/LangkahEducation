<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class TryoutPaket extends Model
{
    protected $table = "tryout_paket";
    protected $fillable = ['user_id', 'tryout_kategori_id', 'nama', 'slug', 'tgl_akhir', 'status'];

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

    public function kategori() {
        return $this->belongsTo('App\Models\TryoutKategori','tryout_kategori_id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
