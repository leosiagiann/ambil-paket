@extends('layouts.template')
@include('layouts.customer.sidebar')
@include('layouts.navbar')
@section('content')
<div class="card shadow m-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
    </div>
    <div class="card-body">
        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('assets/img/customer_profile/' . auth()->user()->profile->profile_picture) }}"
                    class="img-thumbnail" alt="">
                <div class="text-center">
                    <small class="text-muted">
                        {{ auth()->user()->email }}
                    </small>
                </div>
            </div>
            <div class="col-md-8">
                <form action="{{ route('customer.edit-profile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="profile_picture">Profile Picture</label>
                        <input type="file" class="form-control-file" id="profile_picture" name="profile_picture">
                        @error('profile_picture')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ auth()->user()->name }}">
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="" @if (auth()->user()->profile->gender == '') selected @endif>Custom
                            </option>
                            <option value="Male" @if (auth()->user()->profile->gender == 'Male') selected @endif>Male
                            </option>
                            <option value="Female" @if (auth()->user()->profile->gender == 'Female') selected
                                @endif>Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                            value="{{ auth()->user()->profile->phone_number }}">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                            value="{{ auth()->user()->profile->address }}">
                        <small class="form-text text-muted">Format: Provinsi-Kabupaten/Kota-Kecamatan-Kode Pos</small>
                    </div>
                    <div class="form-group">
                        <label for="detail_address">Detail Address</label>
                        <textarea name="detail_address" id="detail_address" name="detail_address" cols="30" rows="10"
                            class="form-control"
                            placeholder="Contoh: Jalan merdeka 2 depan gedung sate">{{ auth()->user()->profile->detail_address }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection