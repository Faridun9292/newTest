<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        validator(request()->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ])->validate();

        $user = User::where('email', request('email'))->first();

        if (Hash::check(request('password'), $user->getAuthPassword())){
            return [
                'code' => 200,
                'token' => $user->createToken(time())->plainTextToken,
                'name' => $user->name,
                'id' => $user->id,
            ];
        } else {

            return response()->json(['error' =>'Не правильные данные']);

        }
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json(['success' => 200 ]);
    }
}
