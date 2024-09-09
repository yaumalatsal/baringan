@extends('admin.layouts.app')

@php
    use Carbon\Carbon;

    // Set the locale to Indonesian
    Carbon::setLocale('id');

    // Format the date

@endphp

@section('content')
    <div class="container-fluid d-flex justify-content-between fw-bold pt-4">
        <h3>Detail Barang</h3>
        <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-block btn-warning w-auto">Edit Item</a>
    </div>
    <div class="row mt-4">
        <div class="col-md-6 mx-auto">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Detail Barang</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <h1>{{ $item->name }}</h1>
                    <div class="item-image-wrapper my-3">
                        <img src="{{ $item->image ? asset('storage/images/' . $item->image) : asset('image/image-not-found.jpeg') }}"
                            alt="{{ $item->name }}" class="img-fluid">
                    </div>
                    <p><strong>Code:</strong> {{ $item->code }}</p>
                    <p><strong>Merk:</strong> {{ $item->merk }}</p>
                    <p><strong>Tanggal Terakhir Cek:</strong>
                        {{ $formattedDateItem = Carbon::parse($item->updated_at)->translatedFormat('l, j F Y, H:i') }}
                    </p>
                    <p><strong>Kondisi Barang:</strong> {{ $item->condition }}</p>
                    <p><strong>Lantai:</strong> {{ $item->room->floor->name }}</p>
                    <div class="text-center">
                        {{ QrCode::size(100)->generate(url('/admin/items/' . $item->id)) }}
                    </div>

                    <div class="col-12 mt-4">
                        <form action="{{ route('download.qrcode') }}" method="post">
                            @csrf
                            <input type="hidden" name="url" value="{{ url('/admin/items/' . $item->id) }}">
                            <button type="submit" class="btn btn-primary btn-block">Download QR Code</button>
                        </form>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>

        <div class="col-md-12 mt-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">History Pengecekan Barang</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Code</th>
                                <th>Merk</th>
                                <th>Tanggal Cek</th>
                                <th>Kondisi</th>
                                <th>Status Kebersihan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($item->logs as $log)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $log->name }}</td>
                                    <td>{{ $log->code }}</td>
                                    <td>{{ $log->merk }}</td>
                                    <td>{{ $formattedDateItem = Carbon::parse($log->created_at)->translatedFormat('l, j F Y, H:i') }}</td>
                                    <td>{{ $log->condition }}</td>
                                    <td>{{ $log->clean_status ? 'Bersih' : 'Kotor' }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
