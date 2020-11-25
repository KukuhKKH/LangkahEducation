<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TryoutHasil extends Model
{
    protected $table = "tryout_hasil";
    protected $fillable = ['user_id', 'tryout_paket_id', 'nilai_awal', 'nilai_sekarang', 'nilai_maksimal'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function paket() {
        return $this->belongsTo('App\Models\TryoutKategori', 'tryout_paket_id');
    }

    public function tryout_hasil_jawaban() {
        return $this->hasMany('App\Models\TryoutHasilJawaban');
    }
}
