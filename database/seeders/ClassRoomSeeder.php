<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            // Create new 50 students
            DB::table('students')->insert([
                'name' => 'Student ' . $i,
                'email' => 'student' . $i . '@rupp.edu.kh',
                'age' => rand(10, 18),
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            // Create new 10 teachers
            DB::table('teachers')->insert([
                'name' => 'Teacher ' . $i,
                'subject' => 'Subject ' . $i,
                'email' => 'teacher' . $i . '@rupp.edu.kh',
            ]);
        }
    }
}
