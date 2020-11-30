<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PassingGrade extends Model
{
    protected $table = 'passing_grade';
    protected $fillable = ['universitas_id', 'kelompok_id','prodi', 'passing_grade'];
    protected $with = ['universitas'];

    public function universitas() {
        return $this->belongsTo('App\Models\Universitas');
    }

    public function kelompok() {
        return $this->belongsTo('App\Models\KelompokPassingGrade');
    }
}
