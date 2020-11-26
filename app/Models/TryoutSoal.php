<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TryoutSoal extends Model
{
    protected $table = "tryout_soal";
    protected $fillable = ['user_id', 'tryout_paket_id', 'tryout_kategori_soal','soal', 'pembahasan', 'benar', 'salah'];

    public function paket() {
        return $this->belongsTo('App\Models\TryoutPaket', 'tryout_paket_id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function jawaban() {
        return $this->hasMany('App\Models\TryoutJawaban');
    }

    public function sekolah() {
        return $this->belongsToMany("App\Models\TryoutPaket", "sekolah_tryout", 'tryout_paket_id', 'sekolah_id');
    }

    public function kategori_soal() {
        return $this->belongsTo('App\Models\TryoutKategoriSoal');
    }
}
