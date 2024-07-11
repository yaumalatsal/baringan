@extends('admin.layouts.app')


@section('content')
    <div class=" container-fluid d-flex justify-content-between fw-bold pt-4">
        <h3>List Ruangan {{ $lantai->name }}</h3>
    </div>
    <div class="row">
        @foreach ($rooms as $room)
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $room->name }}</h3>

                        {{-- <p>New Orders</p> --}}
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endforeach
    </div>
@endsection