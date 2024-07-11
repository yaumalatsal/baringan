<!DOCTYPE html>
<html>
<head>
    <title>Rooms in {{ $floor->name }}</title>
</head>
<body>
    <h1>Rooms in {{ $floor->name }}</h1>
    <ul>
        @foreach($rooms as $room)
            <li><a href="{{ url('/rooms/' . $room->id . '/items') }}">{{ $room->name }}</a></li>
        @endforeach
    </ul>
</body>
</html>
