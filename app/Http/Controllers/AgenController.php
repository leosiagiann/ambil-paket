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

    public function rejectConfirm(Request $request, Item $item)
    {
        $item->status = 'rejected';
        if ($request->note) {
            $item->note = $request->note;
        }
        $item->save();
        return redirect()->route('agen.confirm')->with('success', 'Paket berhasil ditolak');
    }

    public function acceptConfirm(Request $request, Item $item)
    {
        if (!$this->getFirstBankUser()) {
            return redirect()->route('agen.confirm')->with('error', 'Gagal mengkonfirmasi paket, bank anda belum terdaftar');
        }
        $item->status = 'accepted';
        $item->bank_id = $this->getFirstBankUser()->id;
        $item->price = $request->price;
        $item->time_delivery = $request->time_delivery;
        $item->save();
        return redirect()->route('agen.confirm')->with('success', 'Paket berhasil diterima, Menunggu Konfirmasi dari Customer');
    }

    private function getFirstBankUser()
    {
        return auth()->user()->banks->first();
    }

    private function getAllItemRequest()
    {
        return Item::where('status', 'request')
            ->orWhere('status', 'accepted')
            ->orWhere('status', 'ok')
            ->orWhere('status', 'paid')
            ->latest()
            ->get();
    }
}