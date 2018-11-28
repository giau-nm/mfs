<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Request;

class RequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        // Create Admin
        foreach (range(1, 10) as $i) {
            Request::create([
                'user_id' => $i,
                'device_id' => $i,
                'project_id' => $i,
                'status' => 1,
                'is_long_time' => 1,
                'start_time' => '2018-08-14 13:17:23',
                'end_time' => '2018-08-14 13:17:24',
                'note' => $faker->text
            ]);
        }
    }
}
