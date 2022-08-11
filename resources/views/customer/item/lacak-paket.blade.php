@extends('layouts.template')
@include('layouts.customer.sidebar')
@include('layouts.navbar')
@section('content')
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-lg-9">
                    <a href="#" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-search-location"></i>
                        </span>
                        <span class="text">Lacak Paket</span>
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