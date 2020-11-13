<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Siswa;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Siswa::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'nisn' => $faker->unique()->numberBetween(1000, 99999),
        'asal_sekolah' => $faker->address,
        'tanggal_lahir' => Carbon::parse($faker->dateTimeBetween('1996-08-29', '1998-08-29', 'Asia/Jakarta'))->format('d/m/Y'),
        'nomor_hp' => '+62'.$faker->numberBetween(33333333333, 88888888888),
        'batch' => $faker->randomElement([1,0,0]),
    ];
});