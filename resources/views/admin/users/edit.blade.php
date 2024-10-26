@extends('admin.layouts.app')


@section('content')
<!-- Bootstrap Switch CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Switch JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>

    <div class=" container-fluid d-flex justify-content-between fw-bold pt-4">
        <h3>Edit User</h3>
        {{-- <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline-block;"
            onsubmit="return confirmDelete(this);">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-block btn-danger">Hapus User</button>
        </form> --}}
    </div>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit User</h3>
                </div>

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <!-- Name Field -->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Username Field -->
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror"
                                   value="{{ old('username', $user->username) }}" required>
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Role Field -->
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                <option value="ADMIN" {{ $user->role == 'ADMIN' ? 'selected' : '' }}>Admin</option>
                                <option value="USER" {{ $user->role == 'USER' ? 'selected' : '' }}>User</option>
                                <!-- Add other roles here if needed -->
                            </select>
                            @error('role')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Field (optional, only update if filled) -->
                        <div class="form-group">
                            <label for="password">Password (Leave blank to keep current password)</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Floor Selection Field -->
                        <div class="form-group">
                            <label for="floors">Select Floors</label>
                            <select name="floors[]" id="floors" class="form-control @error('floors') is-invalid @enderror" multiple>
                                @foreach ($floors as $floor)
                                    <option value="{{ $floor->id }}" {{ $user->floors->contains($floor->id) ? 'selected' : '' }}>
                                        {{ $floor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('floors')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update User</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
