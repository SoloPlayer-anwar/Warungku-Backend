<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);


            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormmater::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Register Success');
        }

        catch(Exception $error)
        {
            return ResponseFormmater::error([
                'message' => 'Register Failed',
                'error' => $error,
            ], 'Register Failed', 404);
        }
    }

    public function login (Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $credentials = request(['email', 'password']);

            if(!Auth::attempt($credentials))
            {
                return ResponseFormmater::error([
                    'message' => 'Unauthorized'
                ], 'Unauthorized Failed', 404);
            }

            $user = User::where('email', $request->email)->first();

            if(!Hash::check($request->password, $user->password, []))
            {
                 throw new \Exception('Password is incorrect');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormmater::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Login Success');
        }
        catch(Exception $error)
        {
            return ResponseFormmater::error([
                'message' => 'Login Failed',
                'error' => $error
            ], 'Login Failed', 404);
        }
    }
}
