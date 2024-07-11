@extends('admin.layouts.app')


@section('content')
    <div class=" container-fluid d-flex justify-content-between fw-bold pt-4">
        <h3>List Barang </h3>
        <a href="" class="btn btn-block btn-success w-auto">Add Items</a>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Responsive Hover Table</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>QR</th>
                                <th>Image</th>
                                <th>nama</th>
                                <th>Code</th>
                                <th>Kondisi</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Cek</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ QrCode::size(100)->generate(url('/items/' . $item->id)) }}</td>
                                    <td>John Doe</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->condition }}</td>
                                    <td>{{ $item->entry_date }}</td>
                                    <td>{{ $item->last_checked_date }}</td>
                                    <td>
                                        <div class="flex">
                                            <a href="{{ route('admin.items', $item->id) }}" class="btn btn-block btn-primary">View</a>
                                            <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-block btn-warning">Edit</a>
                                            <a href="" class="btn btn-block btn-danger">Delete</a>
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
