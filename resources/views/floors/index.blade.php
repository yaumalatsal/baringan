<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lantai</title>
</head>
<body>
    <h1>Daftar Lantai</h1>

    <ul>
        @foreach($floors as $floor)
            <li><a href="{{ route('floor.rooms', ['floor' => $floor->id]) }}">{{ $floor->name }}</a></li>
        @endforeach
    </ul>
</body>
</html>
