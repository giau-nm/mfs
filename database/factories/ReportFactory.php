<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Report::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\Models\User::class)->create()->id;
        },
        'project_id' => function () {
            return factory(App\Models\Project::class)->create()->id;
        },
        'device_id' => function () {
            return factory(App\Models\Device::class)->create()->id;
        },
        'content'    => $faker->text(150),
        'status'     => array_rand([0, 1, 2, 3]),
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
