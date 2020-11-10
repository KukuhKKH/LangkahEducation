<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatistikPengunjung extends Model
{
    protected $table = 'statistik_web';
    protected $fillable = ['ip', 'os', 'browser', 'kota', 'negara', 'provinsi', 'long', 'lat'];
}
