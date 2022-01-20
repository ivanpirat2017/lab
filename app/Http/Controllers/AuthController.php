<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'last_name' => 'required',
            'first_name' => 'required',
            'patronymic' => 'required',
            'gender' => 'required|size:1|starts_with:m,w',
            'birthdate' => 'required|date_format:Y-m-d',
            'phone' => 'required|digits:11|unique:users',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ]
            ], 422);
        }

        User::create($request->all());

        return response()->json()->setStatusCode(204);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|digits:11',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ]
            ], 422);
        }

        if($user = User::where('phone', $request->phone)->first()) {
            if($request->password == $user->password) {
                return response()->json([
                    'data' => [
                        'token' => $user->generateToken(),
                    ],
                ]);
            }
        }

        return response()->json([
            'error' => [
                'code' => 401,
                'message' => 'Unauthorized',
                'errors' => [
                    'phone' => [
                        'phone or password incorrect',
                    ]
                ],
            ]
        ], 401);
    }

    public function logout()
    {
        Auth::user()->api_token = null;
        Auth::user()->save();
    }
}
