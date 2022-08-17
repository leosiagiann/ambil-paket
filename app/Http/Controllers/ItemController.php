<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return view('customer.item.index', [
            'title' => 'Kirim Paket',
            'page' => 'Paket',
        ]);
    }

    public function createItem()
    {
        return view('customer.item.create', [
            'title' => 'Kirim Paket',
            'page' => 'Paket',
        ]);
    }

    public function lacakPaket()
    {
        return view('customer.item.lacak-paket', [
            'title' => 'Lacak Paket',
            'page' => 'Paket',
        ]);
    }

    public function riwayatPengiriman()
    {
        return view('customer.item.riwayat-pengiriman', [
            'title' => 'Riwayat Pengiriman',
            'page' => 'Paket',
        ]);
    }
}