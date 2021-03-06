<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempProdi extends Model
{
    protected $table = 'temp_prodi_tryout';
    protected $fillable = ['gelombang_id', 'paket_id', 'user_id', 'passing_grade_id', 'kelompok_passing_grade_id'];

    public function paket() {
        return $this->belongsTo('App\Models\TryoutPaket', 'paket_id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function passing_grade() {
        return $this->belongsTo('App\Models\PassingGrade', 'passing_grade_id');
    }

    public function kelompok() {
        return $this->belongsTo('App\Models\KelompokPassingGrade', 'kelompok_passing_grade_id');
    }
}
