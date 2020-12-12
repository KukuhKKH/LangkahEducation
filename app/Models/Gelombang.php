<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Gelombang extends Model
{
    protected $table = 'gelombang';
    protected $guarded = [];

    public static function boot() {
        parent::boot();
        static::saving(function ($model) {
            $model->slug = Str::slug($model->nama);
        });
    }

    public function setHargaAttribute($value) {
        $this->attributes['harga'] = floor(preg_replace('/[Rp. ]/', '', $value));
    }

    public function pembayaran() {
        return $this->hasMany('App\Models\Pembayaran');
    }

    public function tryout() {
        return $this->belongsToMany("App\Models\TryoutPaket", "gelombang_tryout", 'gelombang_id', 'tryout_paket_id');
    }

    public function siswa() {
        return $this->belongsToMany("App\Models\Siswa", "siswa_has_gelombang");
    }

    public function sekolah() {
        return $this->belongsToMany("App\Models\Sekolah", "sekolah_has_gelombang", 'gelombang_id', 'sekolah_id');
    }
}
