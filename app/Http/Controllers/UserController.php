<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; 
use JWTAuth;
use Illuminate\Support\Facades\Hash; 
use App\Models\User; 

class UserController extends Controller
{
    public function register(Request $request)
    { 
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]); 

        $user->roles()->attach(1); 
        
        return response()->json(['message' => 'Registration Successful.'], 201);
    }

    public function login(Request $request)
{  
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) { 
        $status = 200; 
        $user = Auth::user(); 
        $response = [ 
                'user' => array_merge($user->toArray(), 
                            ['roles' => $user->roles()->get()->toArray()]), 
                'token' => JWTAuth::fromUser($user), 
        ]; 
    }  else { 
        $status = 422;
        $response = ['error' => 'The email or password is incorrect.'];
    }

    return response()->json($response, $status);
    }
    public function getUser(){
    $user = auth()->user();
    $data = array_merge($user->toArray(), ['roles' => $user->roles()->get()->toArray()]);
    return response()->json($data, 200);
    }
}
