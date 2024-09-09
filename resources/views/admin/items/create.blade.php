@extends('admin.layouts.app')


@section('content')
    <div class=" container-fluid d-flex justify-content-between fw-bold pt-4">
        <h3>Add Item</h3>
    </div>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add Item </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter name"
                                name="name">
                        </div>
                        <div class="form-group">
                            <label for="merk">Merk</label>
                            <input type="text" class="form-control" id="merk" placeholder="Enter merk" name="merk">
                        </div>
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="code" class="form-control" id="code" placeholder="Enter code"
                                name="code">
                        </div>
                        <div class="form-group">
                            <label for="condition">Kondisi</label>
                            {{-- <input type="text" class="form-control" id="condition" placeholder="Enter condition"
                                name="condition"> --}}
                            <select id="condition" class="form-control select2bs4" style="width: 100%;" name="condition" required>
                                <option value="">Pilih Kondisi</option>
                                <option value="BAIK">BAIK</option>
                                <option value="RUSAK">RUSAK</option>
                                <option value="TIDAK TERSEDIA">TIDAK TERSEDIA</option>
                            </select>
                        </div>
                        {{-- <div class="form-group">
                            <label for="last_checked_date">Last Checked Date:</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="date" id="last_checked_date" class="form-control datetimepicker-input"
                                    data-target="#reservationdate" name="last_checked_date" />
                            </div>
                        </div> --}}

                        <div class="form-group">
                            <label for="clean_status">Clean Status</label>
                            {{-- <input type="text" class="form-control" id="clean_status" name="clean_status" value="{{ $item->clean_status }}"> --}}
                            <select id="clean_status" class="form-control select2bs4" style="width: 100%;" name="clean_status" required>
                                <option value="">Pilih Status</option>
                                <option value="1">Bersih</option>
                                <option value="0">Kotor</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Lantai</label>
                            <select id="floor" class="form-control select2bs4" style="width: 100%;">
                                <option value="">Select Floor</option>
                                @foreach ($floors as $floor)
                                    <option value="{{ $floor->id }}" {{ $room->floor_id == $floor->id ? 'selected' : '' }}>
                                        {{ $floor->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Room</label>
                            <select id="room" class="form-control select2bs4" style="width: 100%;" name="room_id">
                                <option value="">Select Room</option>
                                @foreach ($rooms as $ruangan)
                                    <option value="{{ $ruangan->id }}" {{ $ruangan->id == $room->id ? 'selected' : '' }}>{{ $ruangan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Image:</label>
                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*"
                                required>
                            {{-- <label for="exampleInputFile">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div> --}}
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
