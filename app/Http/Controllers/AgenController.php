<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Item;
use App\Models\TrackingItem;

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
            'items' => $this->getAllItem(),
            'pathAgenController' => \App\Http\Controllers\AgenController::class,
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

    public function processPaket(Item $item)
    {
        $item->status = 'process';
        $item->save();
        return redirect()->route('agen.confirm')->with('success', 'Paket berhasil diproses');
    }

    public function notProcessPaket(Item $item)
    {
        $item->status = 'not_process';
        $item->save();
        return redirect()->route('agen.confirm')->with('success', 'Paket berhasil ditolak');
    }

    public function infoPaket()
    {
        return view('agen.item.info', [
            'title' => 'Lacak Paket',
            'page' => 'Paket',
            'items' => $this->getAllItemInfo(),
            'pathAgenController' => \App\Http\Controllers\AgenController::class,
        ]);
    }

    public function riwayatPengiriman()
    {
        return view('agen.item.riwayat-pengiriman', [
            'title' => 'Riwayat Pengiriman',
            'page' => 'Paket',
            'items' => $this->getItemHistory(),
            'pathAgenController' => \App\Http\Controllers\AgenController::class,
        ]);
    }



    private function getItemHistory()
    {
        $items =  Item::with('sender', 'receiver', 'bank')
            ->where('status', 'done')
            ->orWhere('status', 'canceled')
            ->orWhere('status', 'rejected')
            ->orWhere('status', 'not_process')
            ->latest()
            ->get();
        return $items;
    }

    public function tambahPosisi(Request $request, Item $item)
    {
        $trackingItem = new TrackingItem();
        $trackingItem->item_id = $item->id;
        $trackingItem->status = $request->status;
        $trackingItem->save();
        return redirect()->route('agen.info-paket')->with('success', 'Posisi Paket berhasil ditambahkan');
    }

    public function finishPosisi(Item $item)
    {
        $trackingItem = new TrackingItem();
        $trackingItem->item_id = $item->id;
        $trackingItem->status = "Paket Telah Diterima";
        $trackingItem->save();
        $item->status = 'done';
        $item->save();
        return redirect()->route('agen.info-paket')->with('success', 'Paket berhasil dikirim');
    }

    private function getFirstBankUser()
    {
        return auth()->user()->banks->first();
    }

    private function getAllItem()
    {
        return Item::where('status', 'request')
            ->orWhere('status', 'accepted')
            ->orWhere('status', 'ok')
            ->orWhere('status', 'paid')
            ->latest()
            ->get();
    }

    private function getAllItemInfo()
    {
        return Item::where('status', 'process')
            ->latest()
            ->get();
    }

    public function getIdUserItem($bank_id)
    {
        $user_id = Bank::find($bank_id)->user_id;
        return $user_id;
    }
}