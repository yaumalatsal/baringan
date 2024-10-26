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
        <h3>List User </h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-block btn-success w-auto">Add Items</a>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List User</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <div class="flex">
                                            {{-- <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-block btn-primary">View</a> --}}
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-block btn-warning">Edit</a>
                                            {{-- <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"  onsubmit="return confirmDelete(this);">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-block btn-danger mt-2">Delete</button>
                                            </form> --}}
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
