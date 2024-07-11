<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Detail</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional: Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .qr-code-img, .item-image {
            max-width: 100%;
            height: auto;
        }
        .item-image-wrapper {
            width: 200px;
            height: 200px;
            overflow: hidden;
            margin-bottom: 1rem;
        }
        .item-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .qr-code-img-wrapper {
            margin: 2rem 0; /* Add margin to the top and bottom */
        }
        @media (min-width: 768px) {
            .desktop-only {
                display: block;
            }
            .mobile-only {
                display: none;
            }
        }
        @media (max-width: 767px) {
            .desktop-only {
                display: none;
            }
            .mobile-only {
                display: block;
                text-align: center;
                margin-top: 1rem;
            }
            .item-image-wrapper {
                margin: 0 auto;
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $item->name }}</h1>
                <div class="item-image-wrapper">
                    <img src="{{ asset('logo/logo-only.png' . $item->image) }}" alt="{{ $item->name }}" class="item-image">
                </div>
                <p><strong>Code:</strong> {{ $item->code }}</p>
                <p><strong>Entry Date:</strong> {{ $item->entry_date }}</p>
                <p><strong>Last Checked Date:</strong> {{ $item->last_checked_date }}</p>
                <p><strong>Condition:</strong> {{ $item->item_condition }}</p>
            </div>
            <div class="col-md-12 text-center desktop-only">
                <div class="qr-code-img-wrapper">
                    {{ QrCode::size(200)->generate(url('/items/' . $item->id)) }}
                </div>
                <form action="{{ route('download.qrcode') }}" method="post">
                    @csrf
                    <input type="hidden" name="url" value="{{ url('/items/' . $item->id) }}">
                    <button type="submit" class="btn btn-primary btn-block">Download QR Code</button>
                </form>
            </div>
        </div>
        <div class="row mobile-only">
            <div class="col-12">
                <div class="qr-code-img-wrapper">
                    {{ QrCode::size(200)->generate(url('/items/' . $item->id)) }}
                </div>
                <form action="{{ route('download.qrcode') }}" method="post">
                    @csrf
                    <input type="hidden" name="url" value="{{ url('/items/' . $item->id) }}">
                    <button type="submit" class="btn btn-primary btn-block">Download QR Code</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
