<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('super_admin.index', [
            'title' => 'Dashboard',
        ]);
    }

    public function admin()
    {
        return view('super_admin.admin.index', [
            'title' => 'Admin',
            'admins' => $this->getAllAdmin(),
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
            'finance' => $this->getAllFinance(),
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}