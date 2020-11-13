<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = ['user_id', 'nisn', 'asal_sekolah', 'tanggal_lahir', 'nomor_hp', 'batch'];
    protected $with = ['user'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function sekolah() {
        return $this->belongsToMany("App\Models\Sekolah", "siswa_has_sekolah");
    }

    public function mentor() {
        return $this->belongsToMany("App\Models\Mentor", "siswa_has_mentor");
    }
}
