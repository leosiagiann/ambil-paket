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
                                @if (count($agen->banks) > 0)
                                @foreach ($agen->banks as $bank)
                                @if (!$loop->first)
                                <br><br>
                                @endif
                                <span class="badge badge-success">{{ $bank->name }}:
                                    {{ $bank->number }} a.n {{ $bank->bank_name }}
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#removeBanks">
                                        <i class="fa fa-trash"></i>
                                    </button> |
                                    <a href="{{ route('finance.agen.createBank', $agen->id) }}">
                                        <button type="button" class="btn btn-primary btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </a>
                                </span>
                                @endforeach
                                @else
                                <span class="badge badge-danger">Belum ada</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('finance.agen.createBank', $agen->id) }}"
                                    class="btn btn-primary btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-plus"></i>
                                    </span>
                                    <span class="text">Tambah Bank</span>
                                </a>
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