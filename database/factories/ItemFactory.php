<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Models\Item::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'price' => 200,
        'location_id' => 1,
        'category_id' => 1,
        'parent_category_id' => null,
    ];
});
