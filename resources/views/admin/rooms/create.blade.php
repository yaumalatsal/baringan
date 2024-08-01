@extends('admin.layouts.app')


@section('content')
    <div class=" container-fluid d-flex justify-content-between fw-bold pt-4">
        <h3>Add Room</h3>
    </div>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add Room</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('admin.rooms.store') }}">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label>Floor</label>
                            <select id="floor" class="form-control select2bs4" style="width: 100%;" name="floor_id">
                                <option value="">Select Floor</option>
                                @foreach ($floors as $floor)
                                    <option value="{{ $floor->id }}" {{ $floor_id == $floor->id ? 'selected' : '' }}>{{ $floor->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter name"
                                name="name">
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="hidden" name="status" value="0"> <!-- Hidden input default value -->
                            <input type="checkbox" name="status" id="status" value="1" data-bootstrap-switch>
                        </div>

                        <div class="form-group">
                            <label for="patient">Patient</label>
                            <input type="hidden" name="patient" value="0"> <!-- Hidden input default value -->
                            <input type="checkbox" name="patient" id="patient" value="1" data-bootstrap-switch>
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
    <script>
        $(function () {
            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
                $(this).on('switchChange.bootstrapSwitch', function(event, state) {
                    $(this).val(state ? 1 : 0);
                });
            });
        });
    </script>
@endsection
