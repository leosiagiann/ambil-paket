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
                <form action="{{ route('finance.agen.updateBank', $bank->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nama Bank</label>
                        <select name="name" id="name" class="form-control @error('name') is-invalid @enderror">
                            <option value="">Pilih Bank</option>
                            @foreach ($types as $type)
                            <option value="{{ $type->name }}" @if($bank->name == $type->name) selected @endif
                                >{{ $type->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="number">Nomor Rekening</label>
                        <input type="text" name="number" id="number"
                            class="form-control @error('number') is-invalid @enderror" placeholder="Nomor Rekening"
                            value="{{ $bank->number }}">
                        @error('number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bank_name">Nama Pemilik Rekening</label>
                        <input type="text" name="bank_name" id="bank_name"
                            class="form-control @error('bank_name') is-invalid @enderror"
                            placeholder="Nama Pemilik Rekening" value="{{ $bank->bank_name }}">
                        @error('bank_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection