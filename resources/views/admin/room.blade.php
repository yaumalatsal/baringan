@extends('admin.layouts.app')

@php
    use Carbon\Carbon;

    // Set the locale to Indonesian
    Carbon::setLocale('id');

    // Format the date

@endphp
@section('content')
@if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    <div class=" container-fluid d-flex justify-content-between fw-bold pt-4">
        <h3>List Barang {{ $room->name }}</h3>
        <a href="{{ route('admin.items.create', ['room_id' => $room->id]) }}" class="btn btn-block btn-success w-auto">Add Items</a>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List Barang</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap table-bordered">
                        <thead>
                            <tr>
                                <th>QR</th>
                                <th>Image</th>
                                <th>nama</th>
                                <th>Code</th>
                                <th>Kondisi</th>
                                <th>Clean Status</th>
                                <th>Merk</th>
                                <th>Tanggal Cek</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ QrCode::size(100)->generate(url('/admin/items/' . $item->id)) }}</td>
                                    <td><img src="{{ $item->image ? asset('storage/images/' . $item->image) : asset('image/image-not-found.jpeg') }}" alt="{{ $item->name }}" class="img-fluid" style="width: 100px; height: 100px;"></td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->condition }}</td>
                                    <td>{{ $item->clean_status ? 'Bersih' : 'Kotor' }}</td>
                                    <td>{{ $item->merk }}</td>
                                    <td>{{ $formattedDateItem = Carbon::parse($item->updated_at)->translatedFormat('l, j F Y, H:i') }}</td>
                                    <td>
                                        <div class="flex">
                                            <a href="{{ route('admin.items', $item->id) }}" class="btn btn-block btn-primary">View</a>
                                            <a href="http://139.255.11.206:8083/espbk" class="btn btn-block btn-info">Tinjau</a>

                                            <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-block btn-warning">Edit</a>
                                            <form action="{{ route('admin.items.delete', $item->id) }}" method="POST"  onsubmit="return confirmDelete(this);">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-block btn-danger mt-2">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                           
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    {{-- <div class="row">
        @foreach ($rooms as $room)
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $room->name }}</h3>

                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endforeach
    </div> --}}
@endsection
