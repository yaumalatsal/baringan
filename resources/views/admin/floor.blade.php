@extends('admin.layouts.app')

@section('content')
<style>
    .status-icon {
        font-size: em;
        border: 8px solid rgb(0, 0, 0);
        border-radius: 50%;
        margin-left: 8px;
    }
    

    .status-text {
        font-weight: bold;

        text-align: right;
        width: 100%;
        margin-top: 3px;
    }
    .status-success {
        color: rgb(0, 255, 0);
    }

    .status-danger {
        color: red;
    }

    
</style>
@if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    <div class="container-fluid d-flex justify-content-between fw-bold pt-4 mb-4">
        <h3>List Ruangan {{ $lantai->name }}</h3>
        <a href="{{ route('admin.rooms.create',['floor_id' => $lantai->id]) }}" class="btn btn-block btn-success w-auto">Add Kamar</a>
    </div>
    <div class="row">
        @foreach ($rooms as $room)
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box {{ $room->patient ? 'bg-info' : 'bg-warning'}} w-full">
                    <div class="inner w-full text-left">
                        <h4 class="font-weight-bold">{{ $room->name }}</h4>
                        
                        <p class="w-full d-flex justify-content-end">
                            <span class="status-text">Status Kamar : </span>
                            <span class="status-text">{{ $room->status ? 'Siap' : 'Belum Siap'}}</span>
                            <i class="fas fa-circle status-icon {{ $room->status ? 'status-success' : 'status-danger'}}"></i>
                        </p>
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
