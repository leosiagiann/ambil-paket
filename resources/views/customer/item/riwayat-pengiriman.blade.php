@extends('layouts.template')
@include('layouts.customer.sidebar')
@include('layouts.navbar')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Riwayat Pengiriman</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        @if($errors->any())
        <div class="card-header py-3">
            <div class="row">
                <div class="col-lg-12">
                    <span class="btn btn-danger disabled">
                        {{ $errors->first() }}
                    </span>
                </div>
            </div>
        </div>
        @endif
        @if(session('msg'))
        <div class="card-header py-3">
            <div class="row">
                <div class="col-lg-12">
                    <span class="btn btn-success disabled">
                        {{ session('msg') }}
                    </span>
                </div>
            </div>
        </div>
        @endif
        <div class=" card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Service</th>
                            <th>Detail</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>isi</td>
                            <td>isi</td>
                            <td>isi</td>
                            <td>
                                isi
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection