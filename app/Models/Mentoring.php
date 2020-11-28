<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentoring extends Model
{
    protected $table = 'mentoring';
    protected $fillable = ['siswa_id', 'mentor_id', 'pengirim', 'pesan', 'status'];

    public function siswa() {
        return $this->belongsTo('App\Models\Siswa');
    }

    public function mentor() {
        return $this->belongsTo('App\Models\Mentor');
    }
}
