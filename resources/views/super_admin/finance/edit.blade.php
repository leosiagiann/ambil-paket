@extends('layouts.template')
@include('layouts.super_admin.sidebar')
@include('layouts.navbar')
@section('content')
<div class="card shadow m-4">
    <div class="card-header py-3">
        <a href="{{ route('super_admin.finance') }}" class="btn btn-warning btn-sm">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('super_admin.finance.update', $finance->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ $finance->name }}">
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ $finance->email }}">
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password">
                                @error('password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password_confirmation">Password
                                    Confirmation</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection