<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $fillable = ['user_id', 'gelombang_id', 'kode_transfer', 'status'];
    protected $with = ['pembayaran_bukti'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function pembayaran_bukti() {
        return $this->hasMany('App\Models\PembayaranBukti');
    }

    public function gelombang() {
        return $this->belongsTo('App\Models\Gelombang');
    }

    public function admin_bayar() {
        return $this->belongsToMany('App\Models\Pembayaran', 'admin_pembayaran', 'user_id', 'pembayaran_id');
    }
}
