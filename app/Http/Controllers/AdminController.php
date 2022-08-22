<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'title' => 'Dashboard',
            'page' => 'Dashboard',
        ]);
    }

    public function customer()
    {
        return view('admin.customer.index', [
            'title' => 'Customer',
            'customers' => $this->getAllCustomer(),
            'page' => 'Users',
        ]);
    }

    public function item()
    {
        return view('admin.item.index', [
            'title' => 'Paket',
            'items' => $this->getAllItem(),
            'page' => 'Paket',
        ]);
    }

    public function activateCustomer(User $customer)
    {
        $customer->status = 'active';
        $customer->save();
        return redirect()->route('admin.customer')->with('success', 'Customer berhasil diaktifkan');
    }

    public function deactivateCustomer(User $customer)
    {
        $customer->status = 'inactive';
        $customer->save();
        return redirect()->route('admin.customer')->with('success', 'Customer berhasil dinonaktifkan');
    }

    public function destroyCustomer(User $customer)
    {
        $customerDel = $customer;
        $customer->delete();
        return redirect()->route('admin.customer')->with('success', 'Customer with email ' . $customerDel->email . ' has been deleted.');
    }

    public function agen()
    {
        return view('admin.agen.index', [
            'title' => 'Agen',
            'agens' => $this->getAllAgens(),
            'page' => 'Users',
        ]);
    }

    public function pengirimanItem()
    {
        return view('admin.item.pengiriman', [
            'title' => 'Pengiriman Paket',
            'items' => $this->getAllItemPengiriman(),
            'page' => 'Paket',
        ]);
    }

    private function getAllItemPengiriman()
    {
        return Item::where('status', 'process')
            ->latest()
            ->get();
    }

    public function activateAgen(User $agen)
    {
        $agen->status = 'active';
        $agen->save();
        return redirect()->route('admin.agen')->with('success', 'Agen berhasil diaktifkan');
    }

    public function deactivateAgen(User $agen)
    {
        $agen->status = 'freeze';
        $agen->save();
        return redirect()->route('admin.agen')->with('success', 'Agen berhasil dinonaktifkan');
    }

    public function destroyAgen(User $agen)
    {
        $agenDel = $agen;
        $agen->delete();
        return redirect()->route('admin.agen')->with('success', 'Agen with email ' . $agenDel->email . ' has been deleted.');
    }

    private function getAllCustomer()
    {
        return User::where('role_id', '5')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    private function getAllAgen()
    {
        return User::where('role_id', '4')
            ->orderBy('created_at', 'desc')
            ->get();
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
}