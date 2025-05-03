<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Classroom
{

    public static function getStudents()
    {
        // return DB::select('SELECT * FROM students');
        return DB::table('students')->get('*');
    }

    public static function getTeachers()
    {
        return DB::table(table: 'teachers')->get('*');
    }

    public static function getTeacherById($id)
    {
        return DB::table('teachers')->where('id', $id)->first();
    }

    // get student by id

    // delete student by id

    // create student

    // create teacher

    // edit student by id

    // edit teacher by id
}