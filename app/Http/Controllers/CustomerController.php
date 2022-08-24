<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
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
            'items' => $this->getCountItem(),
            'itemCancels' => $this->getCountItemCancel(),
        ]);
    }

    public function getCountItemCancel()
    {
        $items =  Item::where('status', 'rejected')
        ->orWhere('status', 'canceled')
        ->orWhere('status', 'not_process')
        ->get();

        $items = $items->filter(function ($item) {
            return $item->user_id == auth()->user()->id;
        });
        
        return $items->count();
    }

    public function getCountItem()
    {
        $items =  Item::where('status', 'done')
        ->get();

        $items = $items->filter(function ($item) {
            return $item->user_id == auth()->user()->id;
        });

        return $items->count();
    }   
}