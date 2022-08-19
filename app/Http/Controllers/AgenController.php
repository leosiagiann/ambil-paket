<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class AgenController extends Controller
{
    public function index()
    {
        return view('agen.index', [
            'title' => 'Dashboard',
            'page' => 'Dashboard',
        ]);
    }

    public function confirmPaket()
    {
        return view('agen.item.confirm', [
            'title' => 'Konfirmasi Paket',
            'page' => 'Paket',
            'items' => $this->getAllItemRequest(),
        ]);
    }

    private function getAllItemRequest()
    {
        // get all item with status request and accepted
        return Item::where('status', 'request')
            ->orWhere('status', 'accepted')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}