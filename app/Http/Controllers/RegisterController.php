<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register', [
            'title' => 'Register',
        ]);
    }

    public function store(Request $request)
    {
        $validate = $this->validateRegister($request);

        $user = [
            'name' => $validate['name'],
            'role_id' => 5,
            'email' => $validate['email'],
            'password' => Hash::make($validate['password']),
        ];

        $newUser = User::create($user);

        $profile = new Profile();
        $profile->user_id = $newUser->id;
        $profile->profile_picture = 'default.png';
        $profile->save();


        return redirect()->route('auth.login')->with('success', 'Successfull! Wait for activation account');
    }

    private function validateRegister(Request $request)
    {
        $validate =  $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email:dns|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        return $validate;
    }
}