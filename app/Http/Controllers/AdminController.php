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
            'agens' => $this->getAllAgen(),
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

    public function generateResi(Item $item)
    {
        $item->resi = $this->generateResiNumber();
        $item->save();
        return redirect()->route('admin.item.pengiriman')->with('success', 'Resi berhasil dicetak');
    }

    private function generateResiNumber()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+=-';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 16; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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

    public function riwayatPengiriman()
    {
        return view('admin.item.riwayat-pengiriman', [
            'title' => 'Riwayat Pengiriman',
            'items' => $this->getAllItemRiwayat(),
            'page' => 'Paket',
        ]);
    }

    private function getAllItemRiwayat()
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