@extends('admin.layouts.app')

@section('content')
    <style>
        .status-icon {
            font-size: 16px;
            /* Set a fixed font size */
            border: 8px solid rgb(0, 0, 0);
            border-radius: 50%;
            /* Ensure it stays circular */
            margin-left: 8px;
            width: 30px;
            /* Set a fixed width */
            height: 30px;
            /* Set a fixed height */
            display: flex;
            /* Flexbox for centering the icon */
            justify-content: center;
            /* Center the icon */
            align-items: center;
            /* Center the icon */
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
        @if (auth()->user()->role === 'ADMIN' || auth()->user()->floors->contains($lantai->id))
            <div class="d-flex">
                <a href="{{ route('admin.floors.edit', ['id' => $lantai->id]) }}" class="btn btn-block btn-warning w-auto">Edit
                    Lantai</a>
                <h3 class="mx-3"> | </h3>
                <a href="{{ route('admin.rooms.create', ['floor_id' => $lantai->id]) }}"
                    class="btn btn-block btn-success w-auto">Add Kamar</a>
            </div>
        @endif
    </div>
    <div class="row">
        @foreach ($rooms as $room)
            <div class="col-lg-4 col-md-6 col-12">
                <!-- small box -->
                <div class="small-box {{ $room->patient ? 'bg-info' : 'bg-warning' }} w-full">
                    <div class="inner w-full text-left">
                        <h4 class="font-weight-bold">{{ $room->name }}</h4>

                        <p class="w-full d-flex justify-content-end">
                            <span class="status-text">Status Kamar : </span>
                            <span class="status-text">{{ $room->status ? 'Siap' : 'Belum Siap' }}</span>
                            <i
                                class="fas fa-circle status-icon {{ $room->status ? 'status-success' : 'status-danger' }}"></i>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('admin.rooms', $room->id) }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                    @if (auth()->user()->role === 'ADMIN' || auth()->user()->floors->contains($lantai->id))
                        <a href="{{ route('admin.rooms.edit', $room->id) }}" class="small-box-footer">Edit <i
                                class="fas fa-solid fa-pen"></i></a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="row mt-5">
    <!-- Kotak Total Pasien -->
    <div class="col-lg-4 col-md-4 col-12">
        <div class="small-box">
            <div class="bg-primary text-center p-2">
                <h4>Total Pasien</h4>
            </div>
            <div class="py-4 bg-white">
                <h1 class="card-text text-center text-bold">{{ $pasien }}</h1>
            </div>
        </div>
    </div>

    <!-- Kotak Total Kamar Siap -->
    <div class="col-lg-4 col-md-4 col-12">
        <div class="small-box">
            <div class="bg-primary text-center p-2">
                <h4>Total Kamar Siap</h4>
            </div>
            <div class="py-4 bg-white">
                <h1 class="card-text text-center text-bold">{{ $room_ready }}</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-12">
        <div class="small-box">
            <div class="bg-primary text-center p-2">
                <h4>Informasi</h4>
            </div>
            <div class="">
                <ul class="list-group">
                    <li class="list-group-item d-flex align-items-center small-text">
                        <span class="color-box bg-primary"></span> Kamar Terisi
                    </li>
                    <li class="list-group-item d-flex align-items-center small-text">
                        <span class="color-box bg-warning"></span> Kamar Kosong
                    </li>
                    <li class="list-group-item d-flex align-items-center small-text">
                        <span class="color-circle bg-success"></span> Kamar Siap
                    </li>
                    <li class="list-group-item d-flex align-items-center small-text">
                        <span class="color-circle bg-danger"></span> Kamar Belum Siap
                    </li>
                </ul>

                <style>
                    /* Ukuran kotak & lingkaran lebih kecil */
                    .color-box, .color-circle {
                        width: 14px;
                        height: 14px;
                        display: inline-block;
                        margin-right: 6px;
                    }

                    .color-box {
                        border-radius: 3px;
                    }

                    .color-circle {
                        border-radius: 50%;
                    }

                    /* Teks lebih kecil */
                    .small-text {
                        font-size: 0.8rem; /* Mengecilkan ukuran teks */
                        padding: 4px 8px; /* Mengurangi padding agar lebih rapat */
                    }

                    .list-group-item {
                        padding: 6px 10px; /* Mengurangi padding agar tidak terlalu besar */
                    }
                </style>


            </div>
        </div>
    </div>
</div>

@endsection
