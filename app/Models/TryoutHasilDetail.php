<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TryoutHasilDetail extends Model
{
    protected $table = 'tryout_hasil_detail';
    protected $fillable = ['tryout_paket_id', 'tryout_kategori_soal_id', 'tryout_hasil_id', 'user_id', 'nilai', 'benar', 'salah', 'kosong'];

    public function paket() {
        return $this->belongsTo('App\Models\TryoutPaket', 'tryout_paket_id');
    }

    public function hasil() {
        return $this->belongsTo('App\Models\TryoutHasil', 'tryout_paket_id');
    }

    public function kategori_soal() {
        return $this->belongsTo('App\Models\TryoutKategoriSoal', 'tryout_kategori_soal_id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
