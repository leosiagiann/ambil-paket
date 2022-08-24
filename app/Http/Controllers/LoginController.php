<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route(auth()->user()->role->name . '.index');
        }

        return view('auth.login');
    }

    public function store(Request $request)
    {
        $validate = $this->validateLogin($request);

        if (Auth::attempt($validate)) {
            if (auth()->user()->status == 'active') {
                $request->session()->regenerate();
                return redirect()->route(Auth::user()->role->name . '.index');
            } elseif(auth()->user()->status == 'inactive') {
                $this->resetAuth();
                return back()->with('login_error', 'Your account has not been activated!');
            } elseif(auth()->user()->status == 'freeze') { 
                $this->resetAuth();
                return back()->with('login_error', 'Your account has been frozen!');
            }
        }

        return back()->with('login_error', 'Login failed! Please try again');
    }

    public function logout()
    {
        $this->resetAuth();
        return redirect()->route('index');
    }

    private function validateLogin(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        return $validate;
    }

    private function resetAuth()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}