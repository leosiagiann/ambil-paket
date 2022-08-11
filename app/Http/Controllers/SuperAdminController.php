<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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