<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Payment;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;
    return [
        //
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
