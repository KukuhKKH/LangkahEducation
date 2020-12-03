<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Notifications\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable 
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token', 'is_active', 'foto', 'activate_token', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new PasswordReset($token));
    }

    public static function boot() {
        parent::boot();
        static::saving(function ($model) {
            $model->api_token = Str::random(10);
        });
    }

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }

    public function siswa() {
        return $this->hasOne('App\Models\Siswa');
    }

    public function sekolah() {
        return $this->hasOne('App\Models\Sekolah');
    }

    public function mentor() {
        return $this->hasOne('App\Models\Mentor');
    }

    public function soal() {
        return $this->hasMany('App\Models\TryoutSoal');
    }

    public function tryout_hasil() {
        return $this->hasMany('App\Models\TryoutHasil');
    }

    public function pembayaran() {
        return $this->hasMany('App\Models\Pembayaran');
    }

    public function blog() {
        return $this->hasMany('App\Models\Blog');
    }
}
