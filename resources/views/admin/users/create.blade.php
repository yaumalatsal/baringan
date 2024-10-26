@extends('admin.layouts.app')


@section('content')
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New User</h3>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <!-- Name Field -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter name" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Username Field -->
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Enter username" value="{{ old('username') }}">
                        @error('username')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter email" value="{{ old('email') }}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Enter password">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Confirmation Field -->
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm password">
                    </div>

                    <!-- Role Field -->
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                            <option value="" disabled selected>Select role</option>
                            <option value="ADMIN" {{ old('role') == 'ADMIN' ? 'selected' : '' }}>Admin</option>
                            <option value="USER" {{ old('role') == 'USER' ? 'selected' : '' }}>User</option>
                            <!-- Add more roles as needed -->
                        </select>
                        @error('role')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="floors">Select Floors</label>
                        <select name="floors[]" id="floors" class="form-control @error('floors') is-invalid @enderror" multiple>
                            @foreach ($floors as $floor)
                                <option value="{{ $floor->id }}" {{ (collect(old('floors'))->contains($floor->id)) ? 'selected' : '' }}>
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
                    <button type="submit" class="btn btn-primary">Create User</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
