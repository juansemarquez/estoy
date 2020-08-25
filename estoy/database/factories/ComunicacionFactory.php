<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comunicacion;
use Faker\Generator as Faker;

$factory->define(Comunicacion::class, function (Faker $faker) {
    return [
        'observaciones' =>  $faker->paragraph(),
        'fecha' => new \DateTime($faker->dateTimeInInterval('-10 days', '+ 9 days')->format("Y-m-d"))
    ];
});
