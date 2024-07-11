<!DOCTYPE html>
<html>
<head>
    <title>Items in {{ $room->name }}</title>
</head>
<body>
    <h1>Items in {{ $room->name }}</h1>
    <table>
        <thead>
            <tr>
                <th>QR Code</th>
                <th>Image</th>
                <th>Code</th>
                <th>Entry Date</th>
                <th>Last Checked Date</th>
                <th>Condition</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if($items && $items->count() > 0)
    <h1>Items in Room {{ $room->name }}</h1>
    <ul>
        @foreach($items as $item)
            <li>{{ $item->name }}</li>
        @endforeach
    </ul>
@else
    <p>No items found in this room.</p>
@endif

        </tbody>
    </table>
    <a href="{{ url('/items/create') }}">Add New Item</a>
</body>
</html>
