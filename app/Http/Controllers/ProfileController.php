<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\User;
use PhpParser\Node\Stmt\Const_;

class ProfileController extends Controller
{
    const PATH = 'assets/img/customer_profile/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer.profile.index', [
            'title' => 'Profile',
        ]);
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
    public function update(Request $request)
    {
        $this->validateProfile($request);

        $profile = Profile::find(auth()->user()->profile->id);
        $image = $request->file('profile_picture');

        if ($image) {
            if ($profile->profile_picture != 'default.png') {
                $this->deleteImage($profile->profile_picture);
            }
            $profile->profile_picture = $this->saveImage($image);
        }

        $profile->phone_number = $request->phone_number;
        $profile->gender = $request->gender;
        $profile->address = $request->address;
        $profile->detail_address = $request->detail_address;
        $profile->save();

        if ($request->name != auth()->user()->name) {
            $user = User::find(auth()->user()->id);
            $user->name = $request->name;
            $user->save();
        }
        return redirect()->route('customer.profile')->with('success', 'Successfully update profile');
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

    private function validateProfile(Request $request)
    {
        return $request->validate([
            'name' => 'required|max:255|min:3',
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8192',
        ]);
    }

    private function saveImage($image)
    {
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path(self::PATH), $image_name);
        return $image_name;
    }

    private function deleteImage($image)
    {
        $image_path = public_path(self::PATH . $image);
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
}