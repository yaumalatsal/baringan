@extends('admin.layouts.app')

@section('content')
<div class="container-fluid pt-4">
    <h3 class="text-center mb-4">Detail Pengguna</h3>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="card-title mb-0">Informasi Pengguna</h4>
                </div>
                <div class="card-body">
                    <!-- Display User Details -->
                    <div class="mb-3">
                        <label class="text-muted"><strong>Nama:</strong></label>
                        <p class="pl-2">{{ $user->name }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted"><strong>Username:</strong></label>
                        <p class="pl-2">{{ $user->username }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted"><strong>Email:</strong></label>
                        <p class="pl-2">{{ $user->email }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted"><strong>Role:</strong></label>
                        <span class="badge badge-info p-2">{{ $user->role }}</span>
                    </div>

                    <!-- Display Floor Access -->
                    <div class="mt-4">
                        <label class="text-muted"><strong>Akses:</strong></label>
                        @if($user->floors->isEmpty())
                            <p class="pl-2">Tidak ada akses lantai yang ditugaskan.</p>
                        @else
                            <ul class="list-group list-group-flush rounded shadow-sm">
                                @foreach($user->floors as $floor)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-building mr-2 text-primary"></i>
                                            <span>{{ $floor->name }}</span>
                                        </div>
                                        <span class="badge badge-pill badge-secondary">Memiliki Akses</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="card-footer bg-light text-right">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Kembali ke List User</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
    .card {
        border-radius: 15px;
    }

    .card-header {
        font-size: 1.2em;
        font-weight: 500;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .card-body label {
        font-weight: bold;
        color: #555;
    }

    /* .card-body p {
        margin: 0;
        color: #333;
    } */

    .badge-info {
        background-color: #17a2b8;
        color: white;
        font-size: 0.9em;
    }

    .list-group-item {
        font-size: 1em;
        padding: 10px 15px;
    }

    /* Styling for floor access */
    .list-group-item .fas {
        font-size: 1.2em;
    }

    .badge-pill {
        font-size: 0.8em;
        background-color: #6c757d;
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .card {
            margin: 20px;
        }
        
        .card-header, .card-footer {
            text-align: center;
        }
    }
</style>
@endsection
