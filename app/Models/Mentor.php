<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    protected $table = 'mentor';
    protected $fillable = ['user_id', 'pendidikan_terakhir'];
    protected $with = ['user'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function siswa() {
        return $this->belongsToMany("App\Models\Siswa", "siswa_has_mentor");
    }
}
