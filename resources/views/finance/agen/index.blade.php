@extends('layouts.template')
@include('layouts.finance.sidebar')
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
                            <th>Bank Account</th>
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
                                @if ($agen->bank)
                                <span class="badge badge-success">{{ $agen->bank->name }}:
                                    {{ $agen->bank->number }}</span>
                                @else
                                <span class="badge badge-danger">Belum ada</span>
                                @endif
                            </td>
                            <td>
                                @if ($agen->bank)
                                <!-- make button modal to update bank information user -->
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#updateBank{{ $agen->id }}">
                                    <i class="fas fa-edit"></i> Ubah Akun Bank
                                </button>
                                @else
                                <!-- make button modal to add bank information user -->
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#addBank{{ $agen->id }}">
                                    <i class="fas fa-plus"></i> Tambah Akun Bank
                                </button>
                                @endif
                                <!-- modal addBank{{ $agen->id }} -->
                                <div class="modal fade" id="addBank{{ $agen->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="addBank{{ $agen->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addBank{{ $agen->id }}Label">Tambah
                                                    Akun Bank</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="#" method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="bank_name">Nama Bank</label>
                                                        <input type="text" class="form-control" id="bank_name"
                                                            name="bank_name" placeholder="Nama Bank">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="bank_number">Nomor Rekening</label>
                                                        <input type="text" class="form-control" id="bank_number"
                                                            name="bank_number" placeholder="Nomor Rekening">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="bank_name">Nama Pemilik Rekening</label>
                                                        <input type="text" class="form-control" id="bank_name"
                                                            name="bank_name" placeholder="Nama Pemilik Rekening">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Tambah</button>
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