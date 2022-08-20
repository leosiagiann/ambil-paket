<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
        ]);
    }

    public function storeBank(Request $request, User $agen)
    {
        $agen->bank()->create($request->all());
        return redirect()->route('finance.agen.index');
    }

    private function getAllAgen()
    {
        return User::where('role_id', '4')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}