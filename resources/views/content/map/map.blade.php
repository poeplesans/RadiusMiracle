@extends('layouts.main.main')

@section('container')
    <div id="map" style="height: 800px;"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([-8.073926, 111.907725], 13);

            // Adding the OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Fetch lines and add to map
            fetchLines().then(lines => {
                lines.forEach(line => {
                    var coordinates = line.coordinates.map(coord => [coord.lng, coord
                    .lat]); // Corrected lat, lng order

                    if (coordinates.length > 0) {
                        console.log('Coordinates:', coordinates); // Debugging

                        // Create a polyline on the map
                        var polyline = L.polyline(coordinates, {
                            color: 'blue'
                        }).addTo(map);

                        // Fit map bounds to polyline
                        try {
                            var bounds = polyline.getBounds();
                            if (bounds.isValid()) {
                                map.fitBounds(bounds);
                            } else {
                                console.warn('Invalid bounds for polyline', bounds);
                            }
                        } catch (error) {
                            console.error('Error fitting bounds:', error);
                        }

                        // Convert coordinates to GeoJSON LineString format
                        var geojsonLine = turf.lineString(coordinates.map(coord => [coord[1], coord[
                            0]])); // Swap lat, lng for Turf.js

                        // Calculate total distance using turf.js in kilometers
                        var totalDistance = turf.length(geojsonLine, {
                            units: 'kilometers'
                        });
                        const defaultColor = 'blue';

                        // Handle polyline click event
                        polyline.on('click', function(e) {
                            polyline.setStyle({
                                color: 'green'
                            });

                            // Optional: Store original color to revert later
                            if (!window.originalPolylineColors) {
                                window.originalPolylineColors = {};
                            }
                            window.originalPolylineColors[line.id] = defaultColor;

                            window.currentLineId = line.id;
                            window.currentPolyline = polyline;
                            window.currentGeojsonLine = geojsonLine;
                            window.currentTotalDistance = totalDistance;

                            L.popup()
                                .setLatLng(e.latlng)
                                .setContent(
                                    `<div>Total Jarak: ${(totalDistance * 1000).toFixed(2)} m<br>
                                    Jumlah Tiang : ${((totalDistance * 1000) / 50).toFixed(0)} Titik<br>
                                    ${line.name}<br>${line.id}<br>
                                    <button class="btn btn-sm btn-outline-info" onclick="divideLine()">Buat Titik Setiap 50 Meter</button></div>`
                                )
                                .openOn(map);
                        });
                    } else {
                        console.warn('No coordinates available for line:', line.name);
                    }
                });
                console.log('Get Coordinates Data Success'); // Debugging
            });
            fetchPoints().then(points => {
                points.forEach(function(latlng) {
                    L.marker([latlng.latitude, latlng.longitude]).addTo(map);
                });
                console.log('Get Points Data Success'); // Debugging
            });

            function fetchPoints() {
                return fetch('{{ url('/map/point') }}')
                    .then(response => response.json())
                    .then(data => data);
            }
            // Fetch lines data from API
            function fetchLines() {
                return fetch('{{ url('/map/lines') }}')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to fetch lines: ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(lines => {
                        console.log('Lines:', lines); // Debugging to check JSON response
                        return lines;
                    })
                    .catch(error => {
                        console.error('Error fetching lines:', error);
                    });
            }

            // Divide line into points every 50 meters
            window.divideLine = function() {
                var intervalDistance = 0.05; // 50 meters in kilometers
                var points = [];
                var lineId = window.currentLineId;

                if (window.currentGeojsonLine) {
                    var totalDistance = window.currentTotalDistance;
                    for (var i = 0; i <= totalDistance; i += intervalDistance) {
                        var point = turf.along(window.currentGeojsonLine, i, {
                            units: 'kilometers'
                        });
                        points.push({
                            latitude: point.geometry.coordinates[1],
                            longitude: point.geometry.coordinates[0]
                        });
                    }

                    // Add the points to the map as markers
                    var markers = L.layerGroup();
                    points.forEach(function(latlng) {
                        markers.addLayer(L.marker([latlng.latitude, latlng.longitude]));
                    });
                    markers.addTo(map);

                    // Send the points to the server
                    fetch('{{ url('/map/points') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                line_id: lineId,
                                points: points
                            })
                        })
                        .then(response => {
                            console.log('Response Status:', response.status);
                            if (!response.ok) {
                                return response.text().then(text => {
                                    throw new Error('Network response was not ok: ' + text);
                                });
                            }
                            return response.json();
                        })
                        .then(data => console.log('Points saved:', data))
                        .catch(error => console.error('Error saving points:', error));
                } else {
                    console.warn('No current GeoJSON line found');
                }
            };
        });
    </script>
@endsection
