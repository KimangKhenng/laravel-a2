<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
require_once 'vendor/autoload.php';

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 50; $i++) {
            // Create new 50 students
            DB::table('students')->insert([
                'name' => $faker->name(),
                'email' => $faker->email(),
                'age' => fake()->numberBetween(18, 25),
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            // Create new 10 teachers
            DB::table('teachers')->insert([
                'name' => $faker->name(),
                'subject' => $faker()->word(),
                'email' => $faker->email(),
            ]);
        }
    }
}
