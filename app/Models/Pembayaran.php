<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $fillable = ['user_id', 'gelombang_id', 'kode_transfer', 'status'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function pembayaran_bukti() {
        return $this->hasMany('App\Models\PembayaranBukti');
    }

    public function gelombang() {
        return $this->belongsTo('App\Models\Gelombang');
    }
}
