<?php
use Faker\Generator as Faker;
use Plugins\Auto\Entities\Vehicle;
use App\Entities\User;

/*
 * Base vehicle factory
 */
$factory->define(Vehicle::class, function (Faker $faker) {
    return [
        'user_id' => User::where(['email' => 'legomanthomas@yahoo.com'])->first()->id,
//         'user_id' => 1,
        'year' => $faker->year,
        'make' => $faker->country,
        'model' => $faker->city,
        'color' => $faker->safeColorName,
    ];
});

/*
 * Vehicle with vin number
 */
$factory->state(Vehicle::class, 'vin', function(Faker $faker) {
    return [
        'vin' => $faker->numberBetween(1000000, 9999999)
    ];
});

/*
 * Vehicle with trim
 */
$factory->state(Vehicle::class, 'trim', function(Faker $faker) {
    return [
        'trim' => $faker->state
    ];
});