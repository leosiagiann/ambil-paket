@extends('layouts.template')
@include('layouts.agen.sidebar')
@include('layouts.navbar')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Konfirmasi Paket</h6>
        </div>
        <div class=" card-body">
            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
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
                            <th>Bukti Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($item->resi == null)
                                <span class="badge badge-danger">Resi Belum Dibuat</span>
                                @else
                                {{ $item->resi }}
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
                                Rp. {{ number_format($item->price, 0, ',', '.') }}
                            </td>
                            <td>
                                {{ $item->time_delivery }} hari
                            </td>
                            <td>
                                Pengiriman
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
                            <td>
                                <button type="button" class="btn btn-success btn-icon-split" data-toggle="modal"
                                    data-target="#addPositionItem{{ $item->id }}">
                                    <span class="text">Perbaharui Posisi Paket</span>
                                </button>
                                <button type="button" class="btn btn-success btn-icon-split" data-toggle="modal"
                                    data-target="#finishPositionItem{{ $item->id }}">
                                    <span class="text">Paket telah dikirim</span>
                                </button>
                            </td>
                            <!-- modal finishPositionItem{{ $item->id }} -->
                            <div class="modal fade" id="finishPositionItem{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah anda yakin ingin mengkonfirmasi paket telah dikirim?
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button"
                                                data-dismiss="modal">Batal</button>
                                            <form action="{{ route('agen.finish-posisi-paket', $item->id) }}"
                                                method="POST">
                                                @csrf
                                                <button class="btn btn-success" type="submit">Konfirmasi</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- end modal finishPositionItem{{ $item->id }} -->
                            <!-- modal addPositionItem{{ $item->id }} -->
                            <div class="modal fade" id="addPositionItem{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Perbaharui Posisi
                                                Paket</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('agen.tambah-posisi-paket', $item->id)}}"
                                                method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="status">Posisi</label>
                                                    <textarea name="status" id="status" cols="30" rows="10"
                                                        class="form-control"
                                                        placeholder="Posisi Paket Terbaru"></textarea>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal
                                                <i class="fas fa-times"></i></button>
                                            <button class="btn btn-primary" type="submit">Tambah <i
                                                    class="fas fa-plus"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end modal addPositionItem{{ $item->id }} -->
                            <!-- modal for download proof -->
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