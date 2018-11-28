<?php

use Faker\Generator as Faker;
use App\Models\Request;

$factory->define(Request::class, function (Faker $faker) {
    $startTime       = $faker->dateTimeBetween('now', '+7 days');
    $actualStartTime = $faker->dateTimeBetween($startTime, '+7 days');
    $endTime         = $faker->dateTimeBetween($actualStartTime, '+7 days');
    $actualEndTime   = $faker->dateTimeBetween($endTime, '+7 days');
    return [
        'user_id'           => function () {
            return factory(App\Models\User::class)->create()->id;
        },
        'project_id'        => function () {
            return factory(App\Models\Project::class)->create()->id;
        },
        'device_id'         => function () {
            return factory(App\Models\Device::class)->create()->id;
        },
        'status'            => array_rand([
            Request::NEW_REQUEST,
            Request::ACCEPT_REQUEST,
            Request::REJECT_REQUEST
        ], 1),
        'is_long_time'      =>  array_rand([
            Request::LONG_TIME,
            Request::NOT_LONG_TIME
        ], 1),
        'start_time'        => $startTime,
        'end_time'          => $actualStartTime,
        'actual_start_time' => $endTime,
        'actual_end_time'   => $actualEndTime,
        'note'              => null,
        'admin_note' => $faker->text(200),
    ];
});

$factory->state(Request::class, 'expired', function ($faker) {
    $startTime       = $faker->dateTimeBetween('-10 days', '-7 days');
    $actualStartTime = $faker->dateTimeBetween($startTime, strtotime('-5 days'));
    $endTime         = $faker->dateTimeBetween($actualStartTime, strtotime('now'));
    return [
        'status'            => STATUS_REQUEST_ACCEPT,
        'is_long_time'      => REQUEST_NOT_LONG_TIME,
        'start_time'        => $startTime,
        'end_time'          => $actualStartTime,
        'actual_start_time' => $endTime,
        'actual_end_time'   => null,
    ];
});
