<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $table = 'komentar_mentor';
    protected $fillable = ['mentor_id', 'tryout_hasil_id', 'komentar'];
    protected $with = ['mentor'];

    public function mentor() {
        return $this->belongsTo('App\Models\Mentor');
    }

    public function hasil() {
        return $this->belongsTo('App\Models\TryoutHasil', 'tryout_hasil_id');
    }
}
