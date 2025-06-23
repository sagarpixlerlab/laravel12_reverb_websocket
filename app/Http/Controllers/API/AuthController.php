<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
        /**
     * Registration User
     */
    public function register(Request $request)
    {
        $request->validate( [
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::updateOrCreate(
            [
                'email' => $request->email,
            ],
            [
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => 2,
                'password' => bcrypt($request->password)
            ]
        );

        $user->createToken('test')->accessToken;

        return response()->json(['data' => $user]);
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $request->validate( [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($data)) {

            $user = User::where('email', $request->email)->first();
            $user['token'] = $user->createToken('test')->plainTextToken;

            return response()->json([ 'data' => $user ]);
        } else {
            return response()->json(['data' => [] ], 422);
        }
    }

    public function profile(Request $request)
    {
        $user = User::where('id', $request->user()->id)->first();

        return response()->json([ 'data' => $user ]);
    }
}
