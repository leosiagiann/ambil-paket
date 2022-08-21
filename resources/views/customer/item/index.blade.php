@extends('layouts.template')
@include('layouts.customer.sidebar')
@include('layouts.navbar')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('customer.item.create') }}" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-truck"></i>
                </span>
                <span class="text">Kirim Paket</span>
            </a>
        </div>
        <div class=" card-body">
            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
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
                            <th>Pembayaran</th>
                            <th>Aksi</th>
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
                                -
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
                                @if ($item->status == 'request')
                                <span class="badge badge-warning">Belum Disetujui</span>
                                @elseif ($item->status == 'accepted')
                                <span class="badge badge-warning">Lakukan Konfrimasi</span>
                                @elseif ($item->status == 'ok')
                                <span class="badge badge-warning">Lakukan Pembayaran</span>
                                @elseif ($item->status == 'paid')
                                <span class="badge badge-warning">Menunggu Validasi Agen</span>
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
                                @if ($item->status == 'request')
                                <span class="badge badge-warning">Belum Disetujui</span>
                                @elseif ($item->status == 'accepted')
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                    data-target="#confirmYes{{ $item->id }}">
                                    <i class="fa fa-check"></i> Lanjutkan
                                </button>
                                |
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#confirmNo{{ $item->id }}">
                                    <i class="fa fa-times"></i> Batalkan
                                </button>
                                @elseif ($item->status == 'ok')
                                <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                    data-target="#uploadProof{{ $item->id }}">
                                    <i class="fa fa-money-bill"></i> Upload Bukti
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                    data-target="#typeBank{{ $item->id }}">
                                    <i class="fa fa-eye"></i> Jenis Bank
                                </button>
                                @elseif ($item->status == 'paid')
                                <span class="badge badge-warning">Menunggu Validasi Agen</span>
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
                            <!-- modal typeBank{{ $item->id }} -->
                            <div class="modal fade" id="typeBank{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                @php
                                $banks = $pathItemController::getAllBanksAgent($item->bank_id);
                                @endphp
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Jenis Bank</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <strong>Pembayaran dapat dilakukan melalui :</strong>
                                            <p>
                                                @foreach ($banks as $bank)
                                                {{ $bank->name }} : {{ $bank->number }} a.n
                                                {{ $bank->bank_name }}<br>
                                                @endforeach
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end modal typeBank{{ $item->id }} -->
                            <!-- modal transaction{{ $item->id }} -->
                            <div class="modal fade" id="uploadProof{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pembayaran</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('customer.item.payment', $item->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="payment">Metode Pembayaran</label>
                                                    <select name="payment" id="payment" class="form-control">
                                                        <option value="">Pilih Metode Pembayaran</option>
                                                        <option value="transfer">Transfer</option>
                                                        <option value="cod">COD</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="proof">Unggah Bukti Pembayaran</label>
                                                    <input type="file" class="form-control-file" id="proof"
                                                        name="proof">
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button"
                                                data-dismiss="modal">Batal</button>
                                            <button class="btn btn-primary" type="submit">Unggah</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- modal confirmYes{{ $item->id }} -->
                            <div class="modal fade" id="confirmYes{{ $item->id }}" tabindex="-1" role="dialog"
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
                                            Apakah anda yakin ingin melanjutkan proses pengiriman?
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button"
                                                data-dismiss="modal">Batal</button>
                                            <form action="{{ route('customer.item.confirmYes', $item->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">Ya</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end modal confirmYes{{ $item->id }} -->
                            <!-- modal confirmNo{{ $item->id }} -->
                            <div class="modal fade" id="confirmNo{{ $item->id }}" tabindex="-1" role="dialog"
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
                                            Apakah anda yakin ingin membatalkan proses pengiriman?
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button"
                                                data-dismiss="modal">Batal</button>
                                            <form action="{{ route('customer.item.confirmNo', $item->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">Ya</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end modal confirmNo{{ $item->id }} -->
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