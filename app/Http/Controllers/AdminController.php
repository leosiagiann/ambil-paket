<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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

    public function activateCustomer(User $customer)
    {
        $customer->status = 'active';
        $customer->save();
        return redirect()->route('admin.customer');
    }

    public function deactivateCustomer(User $customer)
    {
        $customer->status = 'inactive';
        $customer->save();
        return redirect()->route('admin.customer');
    }

    public function destroyCustomer(User $customer)
    {
        $customerDel = $customer;
        $customer->delete();
        return redirect()->route('admin.customer')->with('success', 'Customer with email ' . $customerDel->email . ' has been deleted.');
    }

    private function getAllCustomer()
    {
        return User::where('role_id', '5')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}