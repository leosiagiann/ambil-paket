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

    private function getAllAgen()
    {
        return User::where('role_id', '4')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}