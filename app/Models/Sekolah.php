<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $table = 'sekolah';
    protected $fillable = ['user_id', 'nama', 'alamat', 'logo', 'kode_referal'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function siswa() {
        return $this->belongsToMany("App\Models\Siswa", "siswa_has_sekolah");
    }
}
