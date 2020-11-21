<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TryoutHasilJawaban extends Model
{
    protected $table = "tryout_hasil_jawaban";
    protected $fillable = ['tryout_hasil_id', 'tryout_soal_id', 'tryout_jawaban_id'];

    public function soal() {
        return $this->belongsTo('App\Models\TryoutSoal', 'tryout_soal_id');
    }
}
