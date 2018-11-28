<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;

class UserTableSeeder extends Seeder
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
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => '123456',
                'type' => 1
            ]);
        }

        // Create User
        foreach (range(1, 10) as $i) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => '123456',
                'type' => 0
            ]);
        }

    }
}
