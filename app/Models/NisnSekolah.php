<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NisnSekolah extends Model
{
    protected $table = 'siswa_nisn_sekolah';
    protected $fillable = ['sekolah_id', 'nisn'];

    public function sekolah() {
        return $this->belongsTo("App\Models\Sekolah");
    }
}
