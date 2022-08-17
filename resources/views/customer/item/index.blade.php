@extends('layouts.template')
@include('layouts.customer.sidebar')
@include('layouts.navbar')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('customer.item.create') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-truck"></i>
                </span>
                <span class="text">Kirim Paket</span>
            </a>
        </div>
        <div class=" card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pengirim</th>
                            <th>Penerima</th>
                            <th>Harga</th>
                            <th>Estimasi Waktu</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>isi</td>
                            <td>isi</td>
                            <td>isi</td>
                            <td>isi</td>
                            <td>isi</td>
                            <td>isi</td>
                            <td>isi</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection