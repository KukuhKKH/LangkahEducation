<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TryoutKategoriSoal extends Model
{
    protected $table = 'tryout_kategori_soal';
    protected $fillable = ['jenis', 'tipe', 'nama', 'kode', 'waktu'];

    public function setKodeAttribute($value) {
        $this->attributes['kode'] = strtoupper($value);
    }
}
