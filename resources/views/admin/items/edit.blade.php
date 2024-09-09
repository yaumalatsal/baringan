@extends('admin.layouts.app')


@section('content')
    <div class=" container-fluid d-flex justify-content-between fw-bold pt-4">
        <h3>Edit Item</h3>
    </div>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Item</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Barang</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}">
                        </div>
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" class="form-control" id="code" name="code" value="{{ $item->code }}">
                        </div>
                        <div class="form-group">
                            <label for="merk">Merk</label>
                            <input type="text" class="form-control" id="merk" placeholder="Enter merk" name="merk" value="{{ $item->merk }}">
                        </div>
                        <div class="form-group">
                            <label for="condition">Kondisi</label>
                            {{-- <input type="text" class="form-control" id="condition" name="condition" value="{{ $item->condition }}"> --}}
                            <select id="condition" class="form-control select2bs4" style="width: 100%;" name="condition" required>
                                <option value="">Pilih Kondisi</option>
                                <option value="BAIK" {{ $item->condition == "BAIK" ? 'selected' : '' }}>BAIK</option>
                                <option value="RUSAK" {{ $item->condition == "RUSAK" ? 'selected' : '' }}>RUSAK</option>
                                <option value="TIDAK TERSEDIA" {{ $item->condition == "TIDAK TERSEDIA" ? 'selected' : '' }}>TIDAK TERSEDIA</option>
                            </select>
                        </div>
                        {{-- <div class="form-group">
                            <label for="entry_date">Entry Date:</label>
                            <input type="date" id="entry_date" class="form-control" name="entry_date" value="{{ $item->entry_date }}">
                        </div>
                        <div class="form-group">
                            <label for="last_checked_date">Last Checked Date:</label>
                            <input type="date" id="last_checked_date" class="form-control" name="last_checked_date" value="{{ $item->last_checked_date }}">
                        </div> --}}

                        <div class="form-group">
                            <label for="clean_status">Clean Status</label>
                            {{-- <input type="text" class="form-control" id="clean_status" name="clean_status" value="{{ $item->clean_status }}"> --}}
                            <select id="clean_status" class="form-control select2bs4" style="width: 100%;" name="clean_status" required>
                                <option value="">Pilih Kondisi</option>
                                <option value="1" {{ $item->clean_status == 1 ? 'selected' : '' }}>Bersih</option>
                                <option value="0" {{ $item->clean_status == 0 ? 'selected' : '' }}>Kotor</option>
                            </select>
                        </div>
            
                        <div class="form-group">
                            <label for="floor">Lantai</label>
                            <select id="floor" name="floor_id" class="form-control select2bs4" style="width: 100%;">
                                <option value="">Select Floor</option>
                                @foreach ($floors as $floor)
                                    <option value="{{ $floor->id }}" {{ $floor->id == $item->room->floor_id ? 'selected' : '' }}>{{ $floor->name }}</option>
                                @endforeach
                            </select>
                        </div>
            
                        <div class="form-group">
                            <label for="room">Room</label>
                            <select id="room" name="room_id" class="form-control select2bs4" style="width: 100%;">
                                <option value="">Select Room</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}" {{ $room->id == $item->room_id ? 'selected' : '' }}>{{ $room->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="image">Image:</label>
                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                            @if($item->image)
                                <img src="{{ asset('storage/images/' . $item->image) }}" alt="Item Image" width="100">
                            @endif
                        </div>
                    </div>
            
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->

        </div>
    </div>
    <script>
        $(function() {
            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
                $(this).on('switchChange.bootstrapSwitch', function(event, state) {
                    $(this).val(state ? 1 : 0);
                });
            });
        });
    </script>
@endsection
