<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        return view('guest.index', [
            'title' => 'Dashboard',
            'page' => 'Dashboard'
        ]);
    }

    public function indexItem()
    {
        return view('guest.item.index', [
            'title' => 'Kirim Paket',
            'page' => 'Paket',
            'items' => $this->getAllItems(),
            'pathItemController' => \App\Http\Controllers\ItemController::class,
        ]);
    }

    public function lacakPaket()
    {
        return view('guest.item.lacak-paket', [
            'title' => 'Lacak Paket',
            'page' => 'Paket',
            'items' => $this->getAllItemsLacak(),
            'pathItemController' => \App\Http\Controllers\ItemController::class,
        ]);
    }

    public function riwayatPengiriman()
    {
        return view('guest.item.riwayat-pengiriman', [
            'title' => 'Riwayat Pengiriman',
            'page' => 'Paket',
            'items' => $this->getItemHistory(),
        ]);
    }
}