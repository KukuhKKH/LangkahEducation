<?php

namespace App\Http\Controllers\Auth;

use App\Models\Siswa;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Mail\VerifikasiEmail;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nisn' => ['required', 'numeric', 'unique:siswa,nisn'],
            'asal_sekolah' => ['required', 'string'],
            'nomor_hp' => ['required', 'numeric'],
            'tanggal_lahir' => ['required', 'string']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'api_token' => Str::random(10),
            'activate_token' => Str::random(30),
        ]);
        $user->assignRole('siswa');
        $tgl = explode('/', $data['tanggal_lahir']);
        $new_tgl = $tgl[1] . "/". $tgl[0] . "/" . $tgl[2];
        Siswa::create([
            'user_id' => $user->id,
            'nisn' => $data['nisn'],
            'nomor_hp' => $data['nomor_hp'],
            'asal_sekolah' => $data['asal_sekolah'],
            'tanggal_lahir' => $new_tgl,
        ]);
        // Mail::to($user->email)->send(new VerifikasiEmail($user));
        return $user;
    }
}
