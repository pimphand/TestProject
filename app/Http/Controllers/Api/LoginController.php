<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request): array
    {
        $request->validate([
            'email' => 'required|string|exists:users,email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(["email" => $request->input("email"), "password" => $request->input("password")])) {
            $user = Auth::user();

            if ($user) {
                $user->tokens()->delete();

                $token = $user->createToken('apk_api' . $user->email, ['user'])->plainTextToken;

                return [
                    'token' => $token,
                    'user' => [
                        'code' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ]
                ];
            }

            throw ValidationException::withMessages([
                'errors' => trans('auth.password'),
            ]);
        }


        throw ValidationException::withMessages([
            'errors' => trans('passwords.user'),
        ]);
    }
}
