<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms in {{ $floor->name }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Rooms in {{ $floor->name }}</h1>
        <ul class="list-group">
            @foreach($rooms as $room)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><a href="{{ url('/rooms/' . $room->id . '/items') }}">{{ $room->name }}</a></span>
                    <div class="btn-group" role="group" aria-label="Room Actions">
                        
                        <a href="{{ url('/rooms/' . $room->id . '/edit') }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ url('/rooms/' . $room->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirmDelete(this);">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
        <a href="{{ route('rooms.create', ['floor' => $floor->id]) }}" class="btn btn-success mt-3">Add New Room</a>
    </div>

    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete(form) {
            return confirm('Are you sure you want to delete this room?');
        }
    </script>
</body>
</html>
