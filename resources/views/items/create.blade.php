<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Item</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Create Item</h1>
        <form action="{{ route('items.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="code">Code</label>
                <input type="text" name="code" id="code" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="floor_id">Floor ID</label>
                <input type="text" name="floor_id" id="floor_id" class="form-control" value="{{ $room->floor_id }}" readonly>
            </div>
            <div class="form-group">
                <label for="room_id">Room ID</label>
                <input type="text" name="room_id" id="room_id" class="form-control" value="{{ $room->id }}" readonly>
            </div>
            <div class="form-group">
                <label for="entry_date">Entry Date</label>
                <input type="date" name="entry_date" id="entry_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="last_checked_date">Last Checked Date</label>
                <input type="date" name="last_checked_date" id="last_checked_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="item_condition">Condition</label>
                <input type="text" name="item_condition" id="item_condition" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
            <!-- Input hidden untuk floor_id dan room_id -->
            
            
            <button type="submit" class="btn btn-success">Create Item</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
