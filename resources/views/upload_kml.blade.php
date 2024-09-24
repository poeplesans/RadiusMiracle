<!DOCTYPE html>
<html>
<head>
    <title>Upload KML File</title>
</head>
<body>
    <h1>Upload KML File</h1>
    <form action="/upload-kml" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="kml_file" accept=".kml">
        <button type="submit">Upload</button>
    </form>
</body>
</html>
