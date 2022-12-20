<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    function register(Request $request)
    {
        $valid = $request->validate([
           // 'name' => 'required ',
            'email' => 'required | unique:users',
           // 'role' => 'required',
           // 'phone_number' => 'required',
            'username' => 'required | unique:users',
            // 'image'=> 'required',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);
        $user = User::create([
            'name' => "name",
          'phone_number'=>"99999999" ,
         'image' => "image",
            'username' => $valid['username'],
           'role' => "user",
            'email' => $valid['email'],
            'password_confirmation' => $valid['password_confirmation'],
            'password' => Hash::make($valid['password']),
        ]);


        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('uploads/images/', $filename);
            $user->image = $filename;

        } else
            $user->image = '';


        $token = $user->createToken('ProductsTolken')->plainTextToken;

//        if( !$valid['username'])
//            return  response()->json([
//                'message' => "The username is already exist",
//
//            ]);

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);


    }

    function login(Request $request)
    {

        $valid = $request->validate([
            'username' => 'required',
            'password' => 'required',

        ]);

        $user = User::where('username', $valid['username'])->first();
        $password = Hash::check($valid['password'], $user->password);
        if (!$user || !$password) {
            return response()->json(['message' => 'Login problem']);
        } else {
            $token = $user->createToken('ProductsTolken')->plainTextToken;
            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        }
    }

    function logout(Request $request)
    {

        $result = auth()->user()->currentAccessToken()->delete();
        if ($result) {
            $response = response()->json('User logout successfully', 200);
        } else {
            $response = response()->json('Something is wrong', 400);
        }
        return $response;

    }
}
