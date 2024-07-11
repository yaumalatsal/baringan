<!DOCTYPE html>
<html>
<head>
    <title>Create Room</title>
</head>
<body>
    <h1>Create Room</h1>
    <form action="{{ route('rooms.store') }}" method="POST">
        @csrf
        <div>
            <label for="floor_id">Floor ID:</label>
            <input type="text" id="floor_id" name="floor_id" required>
        </div>
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <button type="submit">Create Room</button>
    </form>
</body>
</html>
