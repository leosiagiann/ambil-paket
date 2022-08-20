<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bank;
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