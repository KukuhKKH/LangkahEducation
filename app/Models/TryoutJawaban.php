<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TryoutJawaban extends Model
{
    protected $table = "tryout_jawaban";
    protected $fillable = ['tryout_soal_id', 'jawaban', 'benar'];

    public function soal() {
        return $this->belongsTo('App\Models\TryoutSoal');
    }
}
