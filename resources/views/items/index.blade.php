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
                <th>    Nama Baranf</th>
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
                <tr>
                    <td><img src="{{ QrCode::size(50)->generate(url('/items/' . $item->id)) }}" alt="QR Code"></td>
                    <td><img src="{{ asset('path/to/image/') }}" alt="{{ $item->name }}"></td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->entry_date }}</td>
                    <td>{{ $item->last_checked_date }}</td>
                    <td>{{ $item->item_condition }}</td>
                    <td>
                        <a href="{{ url('/items/' . $item->id) }}">View</a>
                        <a href="{{ url('/items/' . $item->id . '/edit') }}">Edit</a>
                    </td>
                </tr>
            @endforeach
    </ul>
@else
    <p>No items found in this room.</p>
@endif
            
        </tbody>
    </table>
    <a href="{{ route('items.create', ['room' => $room->id]) }}">Add New Item</a>

</body>
</html>
