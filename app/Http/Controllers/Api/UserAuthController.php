<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{


    // user register function
    public function register(Request $request)
    {

        // validate user registration
        $request->validate([

            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email',
            'password' => 'required|min:6',

        ]);

        $user = new User();

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        if ($user->save()) {

            $data = [
                'status' => 'success',
                'message' => 'User created Successfully',
            ];
        } else {
            $data = [
                'status' => 'error',
                'message' => 'Something Wrong!',
            ];
        }

        return response()->json($data);
    }


    public function login(Request $request)
    {

        $request->validate([

            'username' => 'required|exists:users',
            'password' => 'required|min:6',

        ]);

        // authentication attempt for user
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {

            // if user request match with database create token
            $accessToken = auth()->user()->createToken('authToken')->accessToken;

            // return response with token and user information 
            $data = [
                'status' => 'success',
                'message' => 'login successful',
                'user' => auth()->user(),
                'token' => $accessToken,
            ];

            return response()->json($data);
        } else {

            // if user login attempt data does not match
            $data = [
                'status' => 'error',
                'message' => 'login Unsuccessfull',

            ];

            return response()->json($data);
        }
    }
}
