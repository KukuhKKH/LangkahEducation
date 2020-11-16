<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TryoutSoal extends Model
{
    protected $table = "tryout_soal";
    protected $fillable = ['user_id', 'tryout_paket_id', 'kategori_id', 'soal', 'pembahasan', 'benar', 'salah'];

    public function paket() {
        return $this->belongsTo('App\Models\TryoutPaket', 'tryout_paket_id');
    }

    public function kategori() {
        return $this->belongsTo('App\Models\TryoutKategori');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function jawaban() {
        return $this->hasMany('App\Models\TryoutJawaban');
    }
}
