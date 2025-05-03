<?php

use Illuminate\Support\Facades\Route;
use App\Models\Classroom;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/students', function () {
    $students = Classroom::getStudents();
    return response()->json($students);
});

Route::get('/teachers', function () {
    $teachers = Classroom::getTeachers();
    return response()->json($teachers);
});

Route::get('/teachers/{id}', function ($id) {
    // Get the teacher by id
    $teacher = Classroom::getTeacherById($id);
    return response()->json($teacher);
});

Route::post('/students', function () {
    // Create a new student
    $body = request()->all();
    return response()->json(['message' => 'Student created', 'data' => $body['name']]);
});

Route::patch('/teachers/{id}', function ($id) {
    // Edit a teacher by id
    // search for the teacher by id
    $body = request()->all();
});
