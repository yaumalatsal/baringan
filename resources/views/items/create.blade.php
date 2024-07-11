<!DOCTYPE html>
<html>
<head>
    <title>Add New Item</title>
</head>
<body>
    <h1>Add New Item</h1>

    <form action="{{ route('items.store') }}" method="post">
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="code">Code:</label>
            <input type="text" id="code" name="code" required>
        </div>
        <div>
            <label for="entry_date">Entry Date:</label>
            <input type="date" id="entry_date" name="entry_date" required>
        </div>
        <div>
            <label for="last_checked_date">Last Checked Date:</label>
            <input type="date" id="last_checked_date" name="last_checked_date" required>
        </div>
        <div>
            <label for="item_condition">Condition:</label>
            <input type="text" id="item_condition" name="item_condition" required>
        </div>
        <div>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
        </div>
        <input type="hidden" name="room_id" value="{{ $room->id }}">
        <button type="submit">Add Item</button>
    </form>

    <a href="{{ url('/rooms/' . $room->id . '/items') }}">Back to Items</a>
</body>
</html>
