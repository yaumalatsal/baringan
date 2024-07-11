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
                <form method="POST" action="{{ route('items.update', ['item' => $item->id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="mx-auto my-4">
                            {{ QrCode::size(100)->generate(url('/items/' . $item->id)) }}
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter name"
                                name="name" value="{{ $item->name }}">
                        </div>
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="code" class="form-control" id="code" placeholder="Enter code"
                                name="code" value="{{ $item->code }}">
                        </div>
                        <div class="form-group">
                            <label for="condition">Kondisi</label>
                            <input type="text" class="form-control" id="condition" placeholder="Enter condition"
                                name="condition" value="{{ $item->condition }}">
                        </div>
                        <div class="form-group">
                            <label for="entry_date">Entry Date:</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="date" id="entry_date" class="form-control datetimepicker-input"
                                    data-target="#reservationdate" name="entry_date" value="{{ $item->entry_date }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_checked_date">Last Checked Date:</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="date" id="last_checked_date" class="form-control datetimepicker-input"
                                    data-target="#reservationdate" name="last_checked_date"
                                    value="{{ $item->last_checked_date }}" />
                            </div>
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
@endsection
