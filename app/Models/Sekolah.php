<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $table = 'sekolah';
    protected $fillable = ['user_id', 'nama', 'alamat', 'logo', 'kode_referal'];
    protected $with = ['user'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function siswa() {
        return $this->belongsToMany("App\Models\Siswa", "siswa_has_sekolah");
    }

    public function tryout() {
        return $this->belongsToMany("App\Models\TryoutPaket", "sekolah_tryout", 'sekolah_id', 'tryout_paket_id');
    }
}
