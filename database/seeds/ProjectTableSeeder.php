<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Project;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        // Create Project
        foreach (range(1, 10) as $i) {
            Project::create([
                'name' => $faker->name,
                'manager' => $i
            ]);
        }
    }
}
