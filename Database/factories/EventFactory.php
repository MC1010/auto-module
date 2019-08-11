<?php
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
 * Base Event
 */
$factory->define(Plugins\Auto\Entities\Event::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTime,
        'name' => $faker->sentence
    ];
});

/*
 * Event with Mileage
 */
$factory->state(Plugins\Auto\Entities\Event::class, 'mileage', function (Faker $faker) {
    return [
        'mileage' => $faker->numberBetween(0, 200000)
    ];
});
    
/*
 * Event with Location
 */
$factory->state(Plugins\Auto\Entities\Event::class, 'location', function (Faker $faker) {
    return [
        'location' => $faker->sentence
    ];
});

/*
 * Event with Notes
 */
$factory->state(Plugins\Auto\Entities\Event::class, 'notes', function (Faker $faker) {
    return [
        'notes' => $faker->paragraph
    ];
});
    
/*
 * Oil Change Event
 */
$factory->state(Plugins\Auto\Entities\Event::class, 'oilChange', function (Faker $faker) {
    return [
        'type' => 1
    ];
});
    
/*
 * Tire Rotation Event
 */
$factory->state(Plugins\Auto\Entities\Event::class, 'tireRotation', function (Faker $faker) {
    return [
        'type' => 2
    ];
});
    
/*
 * Tire Alignment Event
 */
$factory->state(Plugins\Auto\Entities\Event::class, 'tireAlignment', function (Faker $faker) {
    return [
        'type' => 3
    ];
});