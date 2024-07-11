<!DOCTYPE html>
<html>
<head>
    <title>Item Detail</title>
</head>
<body>
    <h1>{{ $item->name }}</h1>
    <img src="{{ asset('path/to/image/' . $item->image) }}" alt="{{ $item->name }}">
    <p>Code: {{ $item->code }}</p>
    <p>Entry Date: {{ $item->entry_date }}</p>
    <p>Last Checked Date: {{ $item->last_checked_date }}</p>
    <p>Condition: {{ $item->item_condition }}</p>
    <img src="{{ QrCode::size(100)->generate(url('/items/' . $item->id)) }}" alt="QR Code">
    <form action="{{ route('download.qrcode') }}" method="post">
        @csrf
        <input type="hidden" name="url" value="{{ url('/items/' . $item->id) }}">
        <button type="submit">Download QR Code</button>
    </form>
</body>
</html>
