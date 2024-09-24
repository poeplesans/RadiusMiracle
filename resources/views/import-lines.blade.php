<!-- resources/views/import-lines.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Import Lines</title>
</head>
<body>
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <form action="{{ url('/map/lines/import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="excel_file" accept=".xlsx,.xls" required>
        <button type="submit">Import</button>
    </form>
</body>
</html>
