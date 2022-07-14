<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;



class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }


    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string|',
            'password' => 'required|string'
        ]);

        // check email
        $user = User::where('email', $fields['email'])->first();

        // check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad credentials'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;


         $perms = [];
        // if (Gate::allows('isAdmin')) {
        //     array_push($perms, 'isAdmin');
        // }

        // if (Gate::allows('isUser')) {
        //     array_push($perms, 'isUser');
        // }

        if (Gate::forUser($user)->allows('isUser')) {
            array_push($perms, 'isUser');
        }

        if (Gate::forUser($user)->allows('isAdmin')) {
            array_push($perms, 'isAdmin');
        }

        $response = [
            'user' => $user,
            'token' => $token,
            'perms' =>  $perms,
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();
        return ['message' => 'Logged out'];
    }

    public function user() {
        return ['user' => auth()->user()];
    }

}
