<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Sekolah;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Sekolah::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'nama' => factory(User::class)->create()->name,
        'alamat' => $faker->address,
        'kode_referal' => Str::random(7)
    ];
});