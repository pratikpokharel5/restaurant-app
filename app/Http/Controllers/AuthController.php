<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function store(LoginRequest $request)
    {
        if ($request->hasArchivedUserWithValidPassword()) {
            return back()
                ->withErrors([
                    'email' => 'Your account has been deactivated. Please contact an administrator for access.',
                ])
                ->onlyInput('email');
        }

        if (Auth::attempt($request->credentials(), $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('categories.index'));
        }

        return back()->withErrors([
            'email' => 'Invalid email or password. Please try again.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
