<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class CustomerController extends Controller
{
    public function index()
    {
        // check users has profile or not
        $user = auth()->user();
        $profile = $user->profile;
        if (!$profile) {
            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->profile_picture = 'default.png';
            $profile->save();
        }
        return view('customer.index', [
            'title' => 'Dashboard',
            'page' => 'Dashboard',
        ]);
    }
}