<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bank;
use App\Models\Item;
use App\Models\TypeBank;

class FinanceController extends Controller
{
    public function index()
    {
        return view('finance.index', [
            'title' => 'Dashboard',
            'page' => 'Dashboard',
        ]);
    }

    public function agen()
    {
        return view('finance.agen.index', [
            'title' => 'Agen',
            'agens' => $this->getAllAgen(),
            'page' => 'Users',
        ]);
    }

    public function createBank(User $agen)
    {
        return view('finance.agen.createBank', [
            'title' => 'Tambah Akun Bank',
            'agen' => $agen,
            'page' => 'Users',
            'types' => $this->getAllTypeBank(),
        ]);
    }

    public function storeBank(Request $request, User $agen)
    {
        $this->validateBank($request);

        $agen->banks()->create($request->all());
        return redirect()->route('finance.agen')->with('success', 'Akun Bank berhasil ditambahkan');
    }

    public function editBank(Bank $bank)
    {
        return view('finance.agen.editBank', [
            'title' => 'Edit Akun Bank',
            'bank' => $bank,
            'page' => 'Users',
            'types' => $this->getAllTypeBank(),
        ]);
    }

    public function updateBank(Request $request, Bank $bank)
    {
        $this->validateBank($request);

        $bank->update($request->all());
        return redirect()->route('finance.agen')->with('success', 'Akun Bank berhasil diperbarui');
    }

    public function destroyBank(Bank $bank)
    {
        $bank->delete();
        return redirect()->route('finance.agen')->with('success', 'Akun Bank berhasil dihapus');
    }

    private function validateBank(Request $request)
    {
        return $request->validate(
            [
                'name' => 'required',
                'number' => 'required',
                'bank_name' => 'required',
            ],
            [
                'name.required' => 'Silahkan pilih nama bank',
                'number.required' => 'Silahkan masukkan nomor rekening',
                'bank_name.required' => 'Silahkan masukkan nama pemilik rekening',
            ]
        );
    }

    public function item()
    {
        return view('finance.item.index', [
            'title' => 'Pengiriman Paket',
            'items' => $this->getAllItem(),
            'page' => 'Paket',
        ]);
    }

    public function itemDone()
    {
        return view('finance.item.done', [
            'title' => 'Riwayat Pengiriman',
            'items' => $this->getAllItemDone(),
            'page' => 'Paket',
        ]);
    }

    public function itemCancel()
    {
        return view('finance.item.cancel', [
            'title' => 'Riwayat Penolakan',
            'items' => $this->getAllItemCancel(),
            'page' => 'Paket',
        ]);
    }

    private function getAllItem()
    {
        return Item::with('sender', 'receiver', 'bank')
            ->where('status', 'request')
            ->orWhere('status', 'accepted')
            ->orWhere('status', 'ok')
            ->orWhere('status', 'paid')
            ->latest()
            ->get();
    }

    private function getAllItemDone()
    {
        return Item::with('sender', 'receiver', 'bank')
            ->where('status', 'done')
            ->latest()
            ->get();
    }

    private function getAllItemCancel()
    {
        return Item::with('sender', 'receiver', 'bank')
            ->where('status', 'canceled')
            ->orWhere('status', 'rejected')
            ->orWhere('status', 'not_process')
            ->latest()
            ->get();
    }

    private function getAllAgen()
    {
        return User::with('banks')
            ->where('role_id', '4')
            ->latest()
            ->get();
    }

    private function getAllTypeBank()
    {
        return TypeBank::all();
    }
}