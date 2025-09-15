<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($data, true)) {
            throw ValidationException::withMessages(['email' => 'Feil e-post eller passord.']);
        }

        $request->session()->regenerate();
        return response()->json(['ok' => true]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['ok' => true]);
    }
}
