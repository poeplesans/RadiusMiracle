<!-- resources/views/map.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Leaflet Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map { height: 600px; }
    </style>
</head>
<body>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('map').setView([0, 0], 2);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Fetch lines from the server
            fetchLines().then(lines => {
                lines.forEach(line => {
                    var latLngs = line.coordinates.map(coord => [coord.lat, coord.lng]);
                    
                    // Create a polyline on the map
                    L.polyline(latLngs, { color: 'blue' }).addTo(map);
                });
            });

            function fetchLines() {
                return fetch('{{ url('/api/lines') }}')
                    .then(response => response.json())
                    .then(data => data);
            }
        });
    </script>
</body>
</html>
