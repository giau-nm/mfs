<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Device;

class DeviceTableSeeder extends Seeder
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
            Device::create([
                'name' => $faker->name,
                'status' => 0,
                'code' => $i,
                'screen_size' => $faker->randomNumber,
                'os' => 'iOS',
                'type' => 'Mobie',
                'manufacture' => $faker->name,
                'carrier' => $faker->name,
                'note' => $faker->text,
                'phone_number' => $faker->phoneNumber,
                'imei' => $faker->randomNumber,
                'udid' => $faker->randomNumber,
                'serial' => $faker->randomNumber
            ]);
        }
    }
}
