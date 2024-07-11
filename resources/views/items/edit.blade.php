<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title>
</head>
<body>
    <h1>Edit Item</h1>

    <form method="POST" action="{{ route('items.update', ['item' => $item->id]) }}">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ $item->name }}">
        </div>

        <div>
            <label for="code">Code:</label>
            <input type="text" id="code" name="code" value="{{ $item->code }}">
        </div>

        <div>
            <label for="entry_date">Entry Date:</label>
            <input type="date" id="entry_date" name="entry_date" value="{{ $item->entry_date }}">
        </div>

        <div>
            <label for="last_checked_date">Last Checked Date:</label>
            <input type="date" id="last_checked_date" name="last_checked_date" value="{{ $item->last_checked_date }}">
        </div>

        <div>
            <label for="item_condition">Condition:</label>
            <input type="text" id="item_condition" name="item_condition" value="{{ $item->item_condition }}">
        </div>

        <button type="submit">Update Item</button>
    </form>

</body>
</html>
