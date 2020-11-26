<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TryoutHasilDetail extends Model
{
    protected $table = 'tryout_hasil_detail';
    protected $fillable = ['tryout_paket_id', 'tryout_soal_id', 'tryout_kategori_soal_id', 'user_id', 'nilai'];

    public function paket() {
        return $this->belongsTo('App\Models\TryoutPaket', 'tryout_paket_id');
    }

    public function soal() {
        return $this->belongsTo('App\Models\TryoutSoal', 'tryout_soal_id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
