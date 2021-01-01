<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TryoutHasil extends Model
{
    protected $table = "tryout_hasil";
    protected $fillable = ['user_id', 'gelombang_id', 'tryout_paket_id', 'nilai_awal', 'nilai_sekarang', 'nilai_maksimal', 'kelompok_passing_grade_id'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function paket() {
        return $this->belongsTo('App\Models\TryoutPaket', 'tryout_paket_id');
    }

    public function gelombang() {
        return $this->belongsTo('App\Models\Gelombang', 'gelombang_id');
    }

    public function tryout_hasil_jawaban() {
        return $this->hasMany('App\Models\TryoutHasilJawaban');
    }

    public function tryout_hasil_detail() {
        return $this->hasMany('App\Models\TryoutHasilDetail');
    }

    public function komentar() {
        return $this->hasOne('App\Models\Komentar', 'tryout_hasil_id');
    }
}
