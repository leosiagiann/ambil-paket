@extends('layouts.template')
@include('layouts.customer.sidebar')
@include('layouts.navbar')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('customer.lacak-paket') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">
                    Kembali
                </span>
            </a>
        </div>
        <div class=" card-body">
            @foreach ($item->trackingItems as $tracking)
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                {{ $tracking->created_at->formatLocalized('%A, %d %B %Y at %H:%M:%S') }}
                            </h6>
                            <h6 class="m-0 font-weight-bold text-primary">
                            </h6>
                        </div>
                        <div class="card-body">
                            <p>{{ $tracking->status }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection