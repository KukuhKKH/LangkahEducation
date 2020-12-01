<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempProdi extends Model
{
    protected $table = 'temp_prodi_tryout';
    protected $fillable = ['paket_id', 'passing_grade_id'];

    public function paket() {
        return $this->belongsTo('App\Models\TryoutPaket', 'paket_id');
    }

    public function passing_grade() {
        return $this->belongsTo('App\Models\PassingGrade', 'passing_grade_id');
    }
}
