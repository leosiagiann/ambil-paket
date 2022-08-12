<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
        return redirect()->route('super_admin.admin');
    }

    public function deactivateAdmin(User $admin)
    {
        $admin->status = 'freeze';
        $admin->save();
        return redirect()->route('super_admin.admin');
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
            $this->validateAdminWithoutPassword($request, $changeEmail);

            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->save();
        } else {
            $this->validateAdmin($request, $changeEmail);

            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);
            $admin->save();
        }

        return redirect()->route('super_admin.admin')->with('success', 'Admin has been updated!');
    }

    private function validateAdmin(Request $request, $changeEmail)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255' . ($changeEmail ? '|unique:users' : ''),
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    private function validateAdminWithoutPassword(Request $request, $changeEmail)
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

    public function getAllAdmin()
    {
        return User::where('role_id', 2)->get();
    }

    public function getAllFinance()
    {
        return User::where('role_id', 3)->get();
    }
}