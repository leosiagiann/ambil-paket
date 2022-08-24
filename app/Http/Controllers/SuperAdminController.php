<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function index()
    {
        return view('super_admin.index', [
            'title' => 'Dashboard',
            'page' => 'Dashboard',
        ]);
    }

    public function admin()
    {
        return view('super_admin.admin.index', [
            'title' => 'Admin',
            'page' => 'Users',
            'admins' => $this->getAllAdmin(),
        ]);
    }

    public function createAdmin()
    {
        return view('super_admin.admin.create', [
            'title' => 'Create Admin',
            'page' => 'Users',
        ]);
    }

    public function storeAdmin(Request $request)
    {
        $this->validateCreateAdmin($request);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
            'status' => 'active',
        ]);
        return redirect()->route('super_admin.admin')->with('success', 'Admin has been created!');
    }

    private function validateCreateAdmin(Request $request)
    {
        return $this->validate($request, [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function activateAdmin(User $admin)
    {
        $admin->status = 'active';
        $admin->save();
        return redirect()->route('super_admin.admin')->with('success', 'Admin has been activated!');
    }

    public function deactivateAdmin(User $admin)
    {
        $admin->status = 'freeze';
        $admin->save();
        return redirect()->route('super_admin.admin')->with('success', 'Admin has been deactivated!');
    }

    public function editAdmin(User $admin)
    {
        return view('super_admin.admin.edit', [
            'title' => 'Edit Admin',
            'page' => 'Users',
            'admin' => $admin,
        ]);
    }

    public function updateAdmin(User $admin, Request $request)
    {
        $changeEmail = true;
        if ($admin->email == $request->email) {
            $changeEmail = false;
        }
        if ($request->password == '') {
            $this->validateUpdateAdminWithoutPassword($request, $changeEmail);

            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->save();
        } else {
            $this->validateUpdateAdmin($request, $changeEmail);

            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);
            $admin->save();
        }

        return redirect()->route('super_admin.admin')->with('success', 'Admin has been updated!');
    }

    private function validateUpdateAdmin(Request $request, $changeEmail)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255' . ($changeEmail ? '|unique:users' : ''),
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    private function validateUpdateAdminWithoutPassword(Request $request, $changeEmail)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255' . ($changeEmail ? '|unique:users' : ''),
        ]);
    }

    public function destroyAdmin(User $admin)
    {
        $admin->delete();
        return redirect()->route('super_admin.admin')->with('success', 'Admin has been deleted!');
    }

    public function finance()
    {
        return view('super_admin.finance.index', [
            'title' => 'Finance',
            'page' => 'Users',
            'finances' => $this->getAllFinance(),
        ]);
    }

    public function createFinance()
    {
        return view('super_admin.finance.create', [
            'title' => 'Create Finance',
            'page' => 'Users',
        ]);
    }

    public function storeFinance(Request $request)
    {
        $this->validateCreateFinance($request);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 3,
            'status' => 'active',
        ]);
        return redirect()->route('super_admin.finance')->with('success', 'Finance has been created!');
    }

    private function validateCreateFinance(Request $request)
    {
        return $this->validate($request, [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function activateFinance(User $finance)
    {
        $finance->status = 'active';
        $finance->save();
        return redirect()->route('super_admin.finance')->with('success', 'Finance has been activated!');
    }

    public function deactivateFinance(User $finance)
    {
        $finance->status = 'freeze';
        $finance->save();
        return redirect()->route('super_admin.finance')->with('success', 'Finance has been deactivated!');
    }

    public function editFinance(User $finance)
    {
        return view('super_admin.finance.edit', [
            'title' => 'Edit Finance',
            'page' => 'Users',
            'finance' => $finance,
        ]);
    }

    public function updateFinance(User $finance, Request $request)
    {
        $changeEmail = true;
        if ($finance->email == $request->email) {
            $changeEmail = false;
        }
        if ($request->password == '') {
            $this->validateUpdateFinanceWithoutPassword($request, $changeEmail);

            $finance->name = $request->name;
            $finance->email = $request->email;
            $finance->save();
        } else {
            $this->validateUpdateFinance($request, $changeEmail);
            $finance->name = $request->name;
            $finance->email = $request->email;
            $finance->password = Hash::make($request->password);
            $finance->save();
        }
        return redirect()->route('super_admin.finance')->with('success', 'Finance has been updated!');
    }

    private function validateUpdateFinance(Request $request, $changeEmail)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255' . ($changeEmail ? '|unique:users' : ''),
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    private function validateUpdateFinanceWithoutPassword(Request $request, $changeEmail)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255' . ($changeEmail ? '|unique:users' : ''),
        ]);
    }

    public function destroyFinance(User $finance)
    {
        $finance->delete();
        return redirect()->route('super_admin.finance')->with('success', 'Finance has been deleted!');
    }

    private function getAllAdmin()
    {
        return User::where('role_id', 5)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    private function getAllFinance()
    {
        return User::where('role_id', 3)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function item()
    {
        return view('super_admin.item.index', [
            'title' => 'Pengiriman Paket',
            'items' => $this->getAllItem(),
            'page' => 'Paket',
        ]);
    }

    public function itemDone()
    {
        return view('super_admin.item.done', [
            'title' => 'Riwayat Pengiriman',
            'items' => $this->getAllItemDone(),
            'page' => 'Paket',
        ]);
    }

    public function itemCancel()
    {
        return view('super_admin.item.cancel', [
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

    public function customer()
    {
        return view('super_admin.customer.index', [
            'title' => 'Customer',
            'customers' => $this->getAllCustomer(),
            'page' => 'Users',
        ]);
    }

    private function getAllCustomer()
    {
        return User::where('role_id', '5')
            ->latest()
            ->get();
    }

    public function agen()
    {
        return view('super_admin.agen.index', [
            'title' => 'Agen',
            'agens' => $this->getAllAgen(),
            'page' => 'Users',
        ]);
    }

    private function getAllAgen()
    {
        return User::where('role_id', '4')
            ->latest()
            ->get();
    }

    public function activateAgen(User $agen)
    {
        $agen->status = 'active';
        $agen->save();
        return redirect()->route('admin.agen')->with('success', 'Agen berhasil diaktifkan');
    }
}