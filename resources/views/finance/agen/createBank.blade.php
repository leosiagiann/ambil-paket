@extends('layouts.template')
@include('layouts.finance.sidebar')
@include('layouts.navbar')
@section('content')
<div class="card shadow m-4">
    <div class="card-header py-3">
        <a href="{{ route('finance.agen') }}" class="btn btn-warning btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('super_admin.admin.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Bank</label>
                        <select name="name" id="name" class="form-control">
                            <option value="">Pilih Nama Bank</option>
                            <option value="BRI">BRI</option>
                            <option value="BNI">BNI</option>
                            <option value="BCA">BCA</option>
                            <option value="Mandiri">Mandiri</option>
                            <option value="Dana">Dana</option>
                            <option value="OVO">OVO</option>
                            <option value="CIMB">CIMB</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bank_number">Nomor Rekening</label>
                        <input type="text" name="bank_number" id="bank_number" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="bank_name">Nama Pemilik Rekening</label>
                        <input type="text" name="bank_name" id="bank_name" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection