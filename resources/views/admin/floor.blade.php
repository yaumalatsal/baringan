@extends('admin.layouts.app')


@section('content')
    <div class=" container-fluid d-flex justify-content-between fw-bold pt-4 mb-4">
        <h3>List Ruangan {{ $lantai->name }}</h3>
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-block btn-success w-auto">Add Kamar</a>
    </div>
    <div class="row">
        @foreach ($rooms as $room)
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-info w-full">
                    <div class="inner w-full text-left">
                        <h4 class="font-weight-bold">{{ $room->name }}</h4>
                        
                        <p class="w-full d-flex justify-content-end">{{ $room->status ? 'Siap' : 'Belum Siap'}}<i class="fas fa-solid fa-circle {{ $room->status ? 'text-success' : 'text-danger'}}"></i></p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('admin.rooms', $room->id) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    <a href="{{ route('admin.rooms.edit', $room->id) }}" class="small-box-footer">Edit  <i class="fas fa-solid fa-pen"></i></a>
                </div>
            </div>
        @endforeach
    </div>
@endsection