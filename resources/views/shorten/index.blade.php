<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shorten Link & QR Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Shorten Link & QR Code Generator</h2>
        
        <!-- Form untuk input URL asli -->
        <form action="{{ route('shorten.store') }}" method="POST">
            @csrf
            <div class="input-group mb-3">
                <input type="url" name="original_url" class="form-control" placeholder="Enter Original URL" required>
                <button class="btn btn-primary" type="submit">Generate</button>
            </div>
        </form>

        <!-- Tampilkan Shortened Links dan QR Codes -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Original URL</th>
                    <th>Shortened URL</th>
                    <th>QR Code</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shortLinks as $link)
                    <tr>
                        <td>{{ $link->original_url }}</td>
                        <td><a href="{{ route('shorten.redirect', $link->shortened_url) }}" target="_blank">{{ url('/' . $link->shortened_url) }}</a></td>
                        <td><img src="{{ asset('QRcode/' . $link->qrcode_image) }}" alt="QR Code" width="100"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
