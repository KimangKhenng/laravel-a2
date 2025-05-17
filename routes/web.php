<?php

use Illuminate\Support\Facades\Route;
use App\Models\Classroom;
use App\Models\User;
use Firebase\JWT\JWT;
use App\Http\Middleware\EnsureTokenIsValid;

Route::middleware([EnsureTokenIsValid::class])->group(function () {
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

    Route::post('/register', function () {
        $body = request()->all();
        $user = new User();
        $user->name = $body['name'];
        $user->email = $body['email'];
        $user->password = bcrypt($body['password']);
        $user->save();
        // response user
        return response()->json(['message' => 'User created', 'data' => $user]);
    })->withoutMiddleware(EnsureTokenIsValid::class);

    Route::post('/login', function () {
        $body = request()->all();
        $email = $body['email'];
        $password = $body['password'];

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if (!password_verify($password, $user->password)) {
            return response()->json(['message' => 'Invalid either email or password'], 401);
        }
        // Sign JWT token
        $payload = [
            'sub' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + 60 * 60,
        ];
        $jwt = JWT::encode($payload, env('JWT_SECRET'), 'HS256');
        return response()->json(['access_token' => $jwt]);
    })->withoutMiddleware(EnsureTokenIsValid::class);
});


