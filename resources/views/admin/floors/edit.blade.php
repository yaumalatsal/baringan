@extends('admin.layouts.app')


@section('content')
    <div class=" container-fluid d-flex justify-content-between fw-bold pt-4">
        <h3>Edit Lantai</h3>
        <form action="{{ route('admin.floors.delete', $floor->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirmDelete(this);">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-block btn-danger">Hapus Lantai</button>
        </form>
    </div>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Lantai</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form  action="{{ route('admin.floors.update', $floor->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter name"
                                name="name" value="{{ $floor->name }}">
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->

        </div>
    </div>
@endsection
