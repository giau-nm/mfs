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

$factory->define(App\Models\Device::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'code' => $faker->randomElement(['NV', 'SP', 'VN', 'LV']) . '-' . $faker->randomNumber(8, true),
        'status' => $faker->numberBetween(0, 2),
        'screen_size' => $faker->randomElement(['600x320', '400x676', '360x640', '375x667']),
        'os' => $faker->randomElement(['Android', 'IOS', 'Other']),
        'type' => $faker->randomElement(['Phone', 'Tablet', 'PC', 'Other']),
        'manufacture' => $faker->randomElement(['BPhone', 'Apple', 'Lenovo', 'Other']),
        'carrier' => $faker->randomElement(['Viettel', 'Mobifone', 'Vinaphone', 'Other']),
        'note' => $faker->text(200),
        'phone_number' => $faker->phoneNumber,
        'imei' => $faker->phoneNumber,
        'udid' => $faker->uuid,
        'serial' => $faker->creditCardNumber,
        'checked_at' => $faker->dateTimeBetween('+1 week', '+1 month'),
        'created_at' => $faker->dateTimeBetween('+1 week', '+1 month')
    ];
});
