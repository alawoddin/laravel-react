<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function register(Request $request) 
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string|min:8',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => $validator->errors()
        ], 400);
    }

    // Create user with hashed password
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'User registered successfully',
        'user' => $user,
        'token' => $token // Fixed typo: removed extra space after 'token'
    ], 201);
}

    // login 
    public function login(Request $request) {


    $validator = Validator::make($request->all(), [
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => $validator->errors()
        ], 400);
    }

    $user = User::where('email' , $request->email)->first();

    if(!$user || Hash::check($request->passowrd, $user->password)) {
        return response()->json([
            'message' => 'Invalid Login Creadials'
        ] , 401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'login successfully',
        'user' => $user,
        'token' => $token
     , 200]);

    }


    public function logout(Request $request) {

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'loggout successfully'
        ] , 200);
    }

  
}