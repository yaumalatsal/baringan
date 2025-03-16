@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid d-flex justify-content-between fw-bold pt-4 mb-4">
        <h3>List Lantai </h3>
        @if (auth()->user()->role === 'ADMIN')
            <a href="{{ route('admin.floors.create') }}" class="btn btn-block btn-success w-auto">Add Lantai</a>
        @endif
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row">
        @foreach ($floors as $floor)
            <div class="col-lg-4 col-md-6 col-12">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner text-left ">
                        <h4 class="font-weight-bold">{{ $floor->name }}</h4>
                        <p class="font-weight-bold">Pasien : {{ $floor->room_total_patients ?? 0 }}</p>

                        {{-- <p>New Orders</p> --}}
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('admin.floors', $floor->id) }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                    @if (auth()->user()->role === 'ADMIN' ||
                            auth()->user()->floors->contains($floor->id))
                        <a href="{{ route('admin.floors.edit', $floor->id) }}" class="small-box-footer">Edit <i
                                class="fas fa-solid fa-pen"></i></a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-6 col-12">
            <div class="small-box">
                <div class="bg-primary text-center p-2">
                    <h4>Total Pasien</h4>
                </div>
                <div class="py-4 bg-white">
                    <h1 class="card-text text-center text-bold">{{ $total_patients }}</h1>
                </div>
            </div>
        </div>

        <!-- Kotak Total Kamar Siap -->
        <div class="col-lg-6 col-md-6 col-12">
            <div class="small-box">
                <div class="bg-primary text-center p-2">
                    <h4>Total Kamar Siap</h4>
                </div>
                <div class="py-4 bg-white">
                    <h1 class="card-text text-center text-bold">{{ $total_rooms }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container d-flex justify-content-between fw-bold pt-4 mb-4">
        <h3>Status Kamar </h3>
    </div>

    <style>
        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            font-size: 1rem;
        }

        .badge-success {
            background-color: rgb(55, 158, 55);
            color: white;
        }

        .badge-danger {
            background-color: rgb(182, 51, 51);
            color: white;
        }
    </style>

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
                                    <td><a href="{{ route('admin.rooms', $room->id) }}">{{ $room->name }}</a></td>
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
