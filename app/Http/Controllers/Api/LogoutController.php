<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * @return string[]
     */
    public function logout(): array
    {
        Auth::user()->tokens()->delete();

        return [
            'message' => 'Logout success',
        ];
    }
}
