<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Mentor;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Mentor::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'pendidikan_terakhir' => $faker->randomElement(['SMA', 'S1', 'S2', 'S3']),
    ];
});