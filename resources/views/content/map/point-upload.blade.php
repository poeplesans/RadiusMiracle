<form action="{{ route('points.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="file">Upload File Excel:</label>
        <input type="file" name="file" required>
    </div>
    <button type="submit">Upload</button>
</form>

@if (session('success'))
    <div>{{ session('success') }}</div>
@endif
