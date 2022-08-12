@extends('layouts.template')
@include('layouts.super_admin.sidebar')
@include('layouts.navbar')
@section('content')
<div class="container-fluid">
    <h6 class="mt-4 text-primary font-weight-bold">Data Admin</h6>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('super_admin.admin.create') }}" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Create Admin</span>
            </a>
        </div>
        <div class=" card-body">
            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                @if ($admin->status == 'active')
                                <span class="badge badge-success">Active</span>
                                @else
                                <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                @if ($admin->status == 'active')
                                <a href="{{ route('super_admin.admin.deactivate', $admin->id) }}"
                                    class="btn btn-danger btn-sm">
                                    <i class="fas fa-user-times"></i>
                                </a>
                                @else
                                <a href="{{ route('super_admin.admin.activate', $admin->id) }}"
                                    class="btn btn-success btn-sm">
                                    <i class="fas fa-user-check"></i>
                                </a>
                                @endif
                                |
                                <a href="{{ route('super_admin.admin.edit', $admin->id) }}"
                                    class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                |
                                <a class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#deleteAdmin{{$admin->id}}">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <div class="modal fade" id="deleteAdmin{{$admin->id}}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete Admin</h5>
                                                <button class="close" type="button" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this admin?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button"
                                                    data-dismiss="modal">Cancel</button>
                                                <form action="{{ route('super_admin.admin.destroy', $admin->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection