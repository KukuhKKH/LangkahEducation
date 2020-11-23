<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Universitas extends Model
{
    protected $table = 'universitas';
    protected $fillable = ['nama'];
    // protected $with = ['passing_grade'];

    public function passing_grade() {
        return $this->hasMany('App\Models\PassingGrade', 'universitas_id');
    }
}
