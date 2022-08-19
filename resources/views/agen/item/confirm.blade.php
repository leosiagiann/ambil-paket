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
                            <th>Pengirim</th>
                            <th>Penerima</th>
                            <th>Harga</th>
                            <th>Estimasi Waktu</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
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
                                @if (!$item->harga)
                                <span class="badge badge-warning">Belum Ditentukan</span>
                                @else
                                Rp. {{ number_format($item->harga, 0, ',', '.') }}
                                @endif
                            </td>
                            <td>
                                @if (!$item->estimasi_waktu)
                                <span class="badge badge-warning">Belum Ditentukan</span>
                                @else
                                {{ $item->estimasi_waktu }} hari
                                @endif
                            </td>
                            <td>
                                @if ($item->status == 'request')
                                <span class="badge badge-warning">Belum Ditentukan</span>
                                @elseif ($item->status == 'accept')
                                <span class="badge badge-success">{{ $item->status }}</span>
                                @elseif ($item->status == 'reject')
                                <span class="badge badge-danger">{{ $item->status }}</span>
                                @elseif ($item->status == 'done')
                                <span class="badge badge-primary">{{ $item->status }}</span>
                                @endif
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
                                @if ($item->status == 'request')
                                <button type="button" class="btn btn-success btn-icon-split" data-toggle="modal"
                                    data-target="#confirmY{{ $item->id }}">
                                    <span class="text">Terima</span>
                                </button>
                                <button type="button" class="btn btn-danger btn-icon-split" data-toggle="modal"
                                    data-target="#confirmX{{ $item->id }}">
                                    <span class="text">Tolak</span>
                                </button>
                                @elseif ($item->status == 'accept')
                                <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal"
                                    data-target="#done{{ $item->id }}">
                                    <span class="text">Selesai</span>
                                </button>
                                @elseif ($item->status == 'reject')
                                <button type="button" class="btn btn-danger btn-icon-split" data-toggle="modal"
                                    data-target="#reject{{ $item->id }}">
                                    <span class="text">Tolak</span>
                                </button>
                                @elseif ($item->status == 'done')
                                <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal"
                                    data-target="#done{{ $item->id }}">
                                    <span class="text">Selesai</span>
                                </button>
                                @endif
                            </td>
                            <!-- modal confirmX -->
                            <div class="modal fade" id="confirmX{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tolak Paket</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('agen.confirm.reject', $item->id) }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="">Catatan</label>
                                                    <textarea class="form-control" name="note" rows="3"></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-dismiss="modal">Batal</button>
                                                    <button class="btn btn-primary" type="submit">Tolak</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end modal confirmX -->
                            <!-- modal confirmY -->
                            <div class="modal fade" id="confirmY{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Terima Paket</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('agen.confirm.accept', $item->id) }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="">Harga</label>
                                                    <input type="number" class="form-control" name="price"
                                                        placeholder="Harga">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Estimasi Waktu</label>
                                                    <input type="number" class="form-control" name="time_delivery"
                                                        placeholder="Estimasi Waktu">
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-dismiss="modal">Batal</button>
                                                    <button class="btn btn-primary" type="submit">Terima</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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