@extends('layouts.template')
@include('layouts.customer.sidebar')
@include('layouts.navbar')
@section('content')
<div class="card shadow m-4">
    <div class="card-header py-3">
        <a href="{{ route('customer.item') }}" class="btn btn-warning btn-sm">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('customer.item.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Pengirim</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="sender_name">Nama Pengirim</label>
                                        <input type="text" class="form-control" id="sender_name" name="sender_name"
                                            placeholder="Nama Pengirim">
                                    </div>
                                    <div class="form-group">
                                        <label for="sender_phone">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="sender_phone" name="sender_phone"
                                            placeholder="Nomor Telepon">
                                    </div>
                                    <div class="form-group">
                                        <label for="sender_address">Alamat Pengirim</label>
                                        <input type="text" class="form-control" id="sender_address"
                                            name="sender_address" placeholder="Alamat Pengirim">
                                    </div>
                                    <div class="form-group">
                                        <label for="sender_detail_address">Detail Alamat Pengirim</label>
                                        <textarea class="form-control" id="sender_detail_address"
                                            name="sender_detail_address"
                                            placeholder="Detail Alamat Pengirim"></textarea>
                                        <small class="form-text text-muted">
                                            <i>*Sertakan nama jalan, kode pos, dan detail posisi rumah</i>
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="use_self"
                                                name="use_self" onkeyup="otherSender()">
                                            <label class="form-check-label" for="use_self">
                                                Gunakan data saya
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Penerima</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="receiver_name">Nama Penerima</label>
                                        <input type="text" class="form-control" id="receiver_name" name="receiver_name"
                                            placeholder="Nama Penerima">
                                    </div>
                                    <div class="form-group">
                                        <label for="receiver_phone">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="receiver_phone"
                                            name="receiver_phone" placeholder="Nomor Telepon">
                                    </div>
                                    <div class="form-group">
                                        <label for="receiver_address">Alamat Penerima</label>
                                        <input type="text" class="form-control" id="receiver_address"
                                            name="receiver_address" placeholder="Alamat Penerima">
                                    </div>
                                    <div class="form-group">
                                        <label for="receiver_detail_address">Detail Alamat Penerima</label>
                                        <textarea class="form-control" id="receiver_detail_address"
                                            name="receiver_detail_address"
                                            placeholder="Detail Alamat Penerima"></textarea>
                                        <small class="form-text text-muted">
                                            <i>*Sertakan nama jalan, kode pos, dan detail posisi rumah</i>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Detail Barang</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="item_weight">Berat Barang</label>
                                        <input type="text" class="form-control" id="item_weight" name="weight"
                                            placeholder="Berat Barang">
                                        <small class="form-text text-muted">
                                            <i>*Dalam satuan kg</i>
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <label for="item_note">Catatan</label>
                                        <textarea class="form-control" id="item_note" name="note"
                                            placeholder="Catatan"></textarea>
                                        <small class="form-text text-muted">
                                            <i>*Contoh: Barang mudah pecah</i>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="submit" class="btn btn-primary">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function otherSender() {
    var use_self = document.getElementById("use_self");
    var sender_name = document.getElementById("sender_name");
    var sender_phone = document.getElementById("sender_phone");
    var sender_address = document.getElementById("sender_address");
    var sender_detail_address = document.getElementById("sender_detail_address");
    if (use_self.checked) {
        sender_name.value = "";
        sender_phone.value = "";
        sender_address.value = "";
        sender_detail_address.value = "";
        sender_name.disabled = true;
        sender_phone.disabled = true;
        sender_address.disabled = true;
        sender_detail_address.disabled = true;
    } else {
        sender_name.disabled = false;
        sender_phone.disabled = false;
        sender_address.disabled = false;
        sender_detail_address.disabled = false;
    }
}
</script>
@endsection