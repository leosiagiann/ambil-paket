@extends('layouts.template')
@include('layouts.super_admin.sidebar')
@include('layouts.navbar')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Pengiriman</h6>
        </div>
        <div class=" card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Resi</th>
                            <th>Pengirim</th>
                            <th>Penerima</th>
                            <th>Harga</th>
                            <th>Estimasi Waktu</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            <th>Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($item->resi)
                                {{ $item->resi }}
                                @else
                                <span class="badge badge-danger">Resi belum dibuat</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal"
                                    data-target="#sender{{ $item->id }}">
                                    <span class="text">Lihat</span>
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal"
                                    data-target="#receiver{{ $item->id }}">
                                    <span class="text">Lihat</span>
                                </button>
                            </td>
                            <td>
                                @if (!$item->price)
                                <span class="badge badge-warning">Belum Disetujui</span>
                                @else
                                Rp. {{ number_format($item->price, 0, ',', '.') }}
                                @endif
                            </td>
                            <td>
                                @if (!$item->time_delivery)
                                <span class="badge badge-warning">Belum Disetujui</span>
                                @else
                                {{ $item->time_delivery }} hari
                                @endif
                            </td>
                            <td>
                            <span class="badge badge-success">Sudah Diterima</span>
                            </td>
                            <td>
                                @if ($item->note)
                                <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal"
                                    data-target="#description{{ $item->id }}">
                                    <span class="text">Lihat</span>
                                </button>
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @if ($item->proof == 'cod')
                                COD
                                @elseif ($item->proof)
                                <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal"
                                    data-target="#proof{{ $item->id }}">
                                    <span class="text">Lihat</span>
                                </button>
                                @else
                                -
                                @endif
                            </td>
                            <!-- modal proof{{ $item->id }} -->
                            <!-- make modal for download proof -->
                            <div class="modal fade" id="proof{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Bukti Pembayaran</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="{{ asset('assets/img/payment/'.$item->proof) }}"
                                                alt="{{ $item->proof }}" class="img-fluid">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <a href="{{ asset('assets/img/payment/'.$item->proof) }}"
                                                class="btn btn-primary" download>
                                                <i class="fa fa-download"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end modal proof{{ $item->id }} -->
                            <!-- modal sender{{ $item->id }} -->
                            <div class="modal fade" id="sender{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Pengirim</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input type="text" class="form-control" id="name"
                                                    value="{{ $item->sender->name }}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">Nomor Telepon</label>
                                                <input type="text" class="form-control" id="phone"
                                                    value="{{ $item->sender->phone }}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="address">Alamat</label>
                                                <input type="text" class="form-control" id="address"
                                                    value="{{ $item->sender->address }}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="detail_address">Detail Alamat</label>
                                                <textarea type="text" class="form-control" id="detail_address"
                                                    disabled>@if($item->sender->detail_address){{ $item->sender->detail_address }}@else - @endif</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end modal sender{{ $item->id }} -->
                            <!-- modal receiver{{ $item->id }} -->
                            <div class="modal fade" id="receiver{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Penerima</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input type="text" class="form-control" id="name"
                                                    value="{{ $item->receiver->name }}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">Nomor Telepon</label>
                                                <input type="text" class="form-control" id="phone"
                                                    value="{{ $item->receiver->phone }}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="address">Alamat</label>
                                                <input type="text" class="form-control" id="address"
                                                    value="{{ $item->receiver->address }}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="detail_address">Detail Alamat</label>
                                                <textarea type="text" class="form-control" id="detail_address"
                                                    disabled>@if($item->receiver->detail_address){{ $item->receiver->detail_address }}@else - @endif</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end modal receiver{{ $item->id }} -->
                            <!-- modal description{{ $item->id }} -->
                            <div class="modal fade" id="description{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="description">Deskripsi</label>
                                                <textarea type="text" class="form-control" id="description"
                                                    disabled>{{ $item->note }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end modal description{{ $item->id }} -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection