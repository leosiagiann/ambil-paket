@extends('layouts.template')
@include('layouts.customer.sidebar')
@include('layouts.navbar')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-lg-9">
                    <a href="#" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-truck"></i>
                        </span>
                        <span class="text">Kirim Paket</span>
                    </a>
                </div>
                <div class="col-lg-3">
                    @if($errors->any())
                    <span class="btn btn-danger disabled">
                        {{ $errors->first() }}
                    </span>
                    @endif
                    @if(session('msg'))
                    <span class="btn btn-success disabled">
                        {{ session('msg') }}
                    </span>
                    @endif
                </div>
            </div>
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