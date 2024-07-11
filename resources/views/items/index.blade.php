<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items in {{ $room->name }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional: Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Items in {{ $room->name }}</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>QR Code</th>
                    <th>Image</th>
                    <th>Lantai</th>
                    <th>Kamar</th>
                    <th>Nama Barang</th>
                    <th>Code</th>
                    <th>Entry Date</th>
                    <th>Last Checked Date</th>
                    <th>Condition</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($items && $items->count() > 0)
                    @foreach($items as $item)
                        <tr>
                            <td><img src="{{ QrCode::size(50)->generate(url('/items/' . $item->id)) }}" alt="QR Code"></td>
                            <td><img src="{{ $item->image ? asset('storage/images/' . $item->image) : asset('image/image-not-found.jpeg') }}" alt="{{ $item->name }}" class="img-fluid" style="width: 100px; height: 100px;">
                            </td>

                            <td>{{ $item->room->floor_id }}</td>
                            <td>{{ $item->room->name }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->entry_date }}</td>
                            <td>{{ $item->last_checked_date }}</td>
                            <td>{{ $item->item_condition }}</td>
                            <td>
                                <a href="{{ url('/items/' . $item->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ url('/items/' . $item->id . '/edit') }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ url('/items/' . $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirmDelete(this);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="text-center">No items found in this room.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <a href="{{ route('items.create', ['room' => $room->id]) }}" class="btn btn-success">Add New Item</a>
    </div>

    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete(form) {
            return confirm('Are you sure you want to delete this item?');
        }
    </script>
</body>
</html>
