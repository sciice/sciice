<?php

use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(\Sciice\Model\Sciice::class, function (Faker $faker) {
    $now = Carbon::now();
    return [
        'name'       => $faker->name,
        'username'   => 'test',
        'mobile'     => '13032323333',
        'email'      => $faker->unique()->safeEmail,
        'password'   => '12345',
        'state'      => true,
        'created_at' => $now,
        'updated_at' => $now,
    ];
});
