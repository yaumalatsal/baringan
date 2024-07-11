@extends('admin.layouts.app')


@section('content')
    <div class=" container-fluid d-flex justify-content-between fw-bold pt-4">
        <h3>Detail Item</h3>
    </div>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Detail Item</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <h1>{{ $item->name }}</h1>
                    <div class="item-image-wrapper">
                        <img src="{{ $item->image ? asset('storage/images/' . $item->image) : asset('image/image-not-found.jpeg') }}" alt="{{ $item->name }}" class="img-fluid" >
                    </div>
                    <p><strong>Code:</strong> {{ $item->code }}</p>
                    <p><strong>Entry Date:</strong> {{ $item->entry_date }}</p>
                    <p><strong>Last Checked Date:</strong> {{ $item->last_checked_date }}</p>
                    <p><strong>Condition:</strong> {{ $item->condition }}</p>
                    <p><strong>Lantai:</strong> {{ $item->room->floor->name }}</p>
                    <p><strong>Room:</strong> {{ $item->room->name }}</p>
                    <div class="text-center">
                        {{ QrCode::size(100)->generate(url('/admin/items/' . $item->id)) }}
                    </div>

                    {{-- <div class="col-12">
                        <form action="{{ route('download.qrcode') }}" method="post">
                            @csrf
                            <input type="hidden" name="url" value="{{ url('/items/' . $item->id) }}">
                            <button type="submit" class="btn btn-primary btn-block">Download QR Code</button>
                        </form>
                    </div> --}}
                </div>
                <!-- /.card -->

            </div>
        </div>
    @endsection
