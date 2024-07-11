@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid d-flex justify-content-between fw-bold pt-4 mb-4">
        <h3>List Lantai </h3>
        <a href="{{ route('admin.floors.create') }}" class="btn btn-block btn-success w-auto">Add Lantai</a>
    </div>
    <div class="row">
        @foreach ($floors as $floor)
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $floor->name }}</h3>

                        {{-- <p>New Orders</p> --}}
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('admin.floors', $floor->id) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    <a href="{{ route('admin.floors.edit', $floor->id) }}" class="small-box-footer">Edit  <i class="fas fa-solid fa-pen"></i></a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="container-fluid d-flex justify-content-between fw-bold pt-4 mb-4">
        <h3>Status Kamar </h3>
    </div>


    <div class="row">
        @foreach ($floors as $floor)
            <div class="col-12 mb-4">
                <h4>{{ $floor->name }}</h4>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Kamar</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($floor->rooms as $room)
                                <tr>
                                    <td>{{ $room->name }}</td>
                                    <td class="text-center">
                                        @if ($room->status == 1)
                                            <span class="badge badge-success">✔</span>
                                        @else
                                            <span class="badge badge-danger">✘</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>

@endsection
