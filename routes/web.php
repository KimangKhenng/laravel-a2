<?php

use Illuminate\Support\Facades\Route;
use App\Models\Classroom;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
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

    Route::post('/login', function () {
        // Get username and password from request body
        $body = request()->all();
        $email = $body['email'];
        $password = $body['password'];
        // Check if the user exists
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        // Check if the password is correct
        if (!password_verify($password, $user->password)) {
            return response()->json(['message' => 'Invalid password'], 401);
        }
        // Generate a JWT token
        // Create payload
        $payload = [
            'sub' => $user->id,
            'iat' => time(),
            'email' => $user->email,
            'name' => $user->name,
            'exp' => time() + 60 * 60,
        ];
        // Encode the payload
        $key = env('JWT_SECRET');
        $jwt = JWT::encode($payload, $key, 'HS256');
        // Return the token
        return response()->json(['access_token' => $jwt]);
    })->withoutMiddleware([EnsureTokenIsValid::class]);

    Route::post('/register', function () {
        // Get username and password from request body
        $body = request()->all();
        // Create a new user
        $user = new User();
        $user->name = $body['name'];
        $user->email = $body['email'];
        $user->password = bcrypt($body['password']);
        $user->save();
        return response()->json(['message' => 'User created', 'data' => $user]);
    })->withoutMiddleware([EnsureTokenIsValid::class]);

    Route::get('/users', function () {
        // Get all users
        $users = User::all();
        return response()->json($users);
    });

});

