<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index', [
            'title' => 'Dashboard',
        ]);
    }

    public function customer()
    {
        return view('admin.customer.index', [
            'title' => 'Customer',
            'customers' => $this->getAllCustomer(),
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

    private function getAllCustomer()
    {
        // get all customer and order by created_at desc
        return User::where('role_id', '5')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}