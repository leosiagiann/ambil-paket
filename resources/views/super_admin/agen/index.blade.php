@extends('layouts.template')
@include('layouts.super_admin.sidebar')
@include('layouts.navbar')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Agen</h6>
        </div>
        <div class=" card-body">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
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
                        @foreach ($agens as $agen)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $agen->name }}</td>
                            <td>{{ $agen->email }}</td>
                            <td>
                                @if ($agen->status == 'active')
                                <span class="badge badge-success">Active</span>
                                @else
                                <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <!-- make icon on of for active or inactiove users -->
                                @if ($agen->status == 'active')
                                <a href="{{ route('admin.agen.deactivate', $agen->id) }}" class="btn btn-danger btn-sm">
                                    <i class="fas fa-user-times"></i>
                                </a>
                                @else
                                <a href="{{ route('admin.agen.activate', $agen->id) }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-user-check"></i>
                                </a>
                                @endif
                                |
                                <a class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#deleteAgen{{$agen->id}}">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <div class="modal fade" id="deleteAgen{{$agen->id}}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete Agen</h5>
                                                <button class="close" type="button" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this agen?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button"
                                                    data-dismiss="modal">Cancel</button>
                                                <form action="{{ route('admin.agen.destroy', $agen->id) }}"
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