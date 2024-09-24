@extends('layouts.main.main')

@section('container')
    <div class="container">
        <div class="row">
            <!-- Map Section -->
            <div class="col-md-8 mb-3 ">
                <div id="map" style="height: 800px; width: 100%;"></div>
            </div>

            <!-- Form Section -->
            <div class="col-md-4">
                <div class="card " style="height: 800px;">
                    <!-- Search form and Rows per Page dropdown -->
                    <h3 class="mt-4 text-center">MAP MENU HELPER</h3>
                    {{-- <div class="col m-3"> --}}
                    <div class="col-md">
                        <div class="accordion m-3 accordion-header-primary" id="accordionStyle1">
                            <div class="accordion-item card">
                                <h2 class="accordion-header">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionStyle1-1" aria-expanded="false">
                                        <i class="bx bx-cog me-2"></i> Setting Map
                                    </button>
                                </h2>

                                <div id="accordionStyle1-1" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionStyle1">
                                    <div class="row m-3">
                                        <div class="col-sm-4 form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" value="" id="mapall">
                                            <label class="form-check-label" for="mapall">All</label>
                                        </div>
                                        <div class="col-sm-4 form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" value="" id="pointer">
                                            <label class="form-check-label" for="pointer">Pointer</label>
                                        </div>
                                        <div class="col-sm-4 form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" value="" id="polyline">
                                            <label class="form-check-label" for="polyline">Polyline</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card">
                                <h2 class="accordion-header">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionStyle1-2" aria-expanded="false">
                                        <i class="bx bx-bar-chart-alt-2 me-2"></i> Group Setting Map
                                    </button>
                                </h2>
                                <div id="accordionStyle1-2" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionStyle1">
                                    <div class="accordion-body">
                                        <form class="card-body" id="formgroupsetting" action="/backbone/group/add"
                                            method="post">
                                            @csrf
                                            <h6 class="fw-normal">1. Location Details</h6>
                                            <div class="row mb-2">
                                                <input type="hidden" id="start-id-hidden" name="start-id">
                                                <label class="col-sm-4 col-form-label text-sm-end" for="start-latitude"
                                                    id="start-id">Start</label>
                                                <div class="col-sm-4">
                                                    <input type="text" id="start-latitude" name="start-latitude"
                                                        class="form-control" placeholder="Latitude Start" readonly />
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" id="start-longitude" name="start-longitude"
                                                        class="form-control" placeholder="Longitude Start" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <input type="hidden" id="end-id-hidden" name="end-id">
                                                <label class="col-sm-4 col-form-label text-sm-end" for="end-latitude"
                                                    id="start-id">End</label>
                                                <div class="col-sm-4">
                                                    <input type="text" id="end-latitude" name="end-latitude"
                                                        class="form-control" placeholder="Latitude End" readonly />
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" id="end-longitude" name="end-longitude"
                                                        class="form-control" placeholder="Longitude End" readonly />
                                                </div>
                                            </div>
                                            <h6 class="fw-normal">2. Location Info</h6>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label text-sm-end"
                                                    for="village">Kecamatan</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="village" class="form-control"
                                                        placeholder="John Doe" name="village" />
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label text-sm-end" for="county">Kab /
                                                    Kota</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="county" class="form-control"
                                                        placeholder="John Doe" name="county" />
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label text-sm-end"
                                                    for="state">Provinsi</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="state" class="form-control"
                                                        placeholder="John Doe" name="state" />
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label text-sm-end"
                                                    for="region">Pulau</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="region" class="form-control"
                                                        placeholder="John Doe" name="region" />
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label text-sm-end" for="display_name">Full
                                                    Address</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="display_name" class="form-control"
                                                        placeholder="John Doe" name="display_name" />
                                                </div>
                                            </div>

                                            <div class="pt-4">
                                                <div class="row justify-content-end">
                                                    <div class="col-sm-9">
                                                        <button type="submit"
                                                            class="btn btn-primary me-sm-2 me-1">Submit</button>
                                                        <button type="reset"
                                                            class="btn btn-label-secondary">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="card accordion-item">
                                <h2 class="accordion-header">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionStyle1-3" aria-expanded="false">
                                        <i class="bx bx-map me-2"></i> Individual Setting Map
                                    </button>
                                </h2>
                                <div id="accordionStyle1-3" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionStyle1">
                                    <div class="accordion-body">
                                        <form class="card-body">
                                            <h6 class="fw-normal">1. Location Details</h6>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label text-sm-end"
                                                    for="latitude">Latitude</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="latitude" class="form-control"
                                                        placeholder="Latitude" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label text-sm-end"
                                                    for="longitude">Longitude</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="longitude" class="form-control"
                                                        placeholder="Longitude" readonly />
                                                </div>
                                            </div>
                                            <h6 class="fw-normal">2. Location Info</h6>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label text-sm-end"
                                                    for="village">Kecamatan</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="village" class="form-control"
                                                        placeholder="John Doe" name="village" />
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label text-sm-end" for="county">Kab /
                                                    Kota</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="county" class="form-control"
                                                        placeholder="John Doe" name="county" />
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label text-sm-end"
                                                    for="state">Provinsi</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="state" class="form-control"
                                                        placeholder="John Doe" name="state" />
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label text-sm-end"
                                                    for="region">Pulau</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="region" class="form-control"
                                                        placeholder="John Doe" name="region" />
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label text-sm-end" for="display_name">Full
                                                    Address</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="display_name" class="form-control"
                                                        placeholder="John Doe" name="display_name" />
                                                </div>
                                            </div>

                                            <div class="pt-4">
                                                <div class="row justify-content-end">
                                                    <div class="col-sm-9">
                                                        <button type="submit"
                                                            class="btn btn-primary me-sm-2 me-1">Submit</button>
                                                        <button type="reset"
                                                            class="btn btn-label-secondary">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <script>
        var map = L.map('map').setView([-8.073926, 111.907725], 13);

        // Adding the OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // let polylineLayers = []
        let cachedLines = []; // Deklarasi variabel cachedLines
        let polylinesGroup = L.layerGroup().addTo(map); // Layer group untuk menyimpan polylines
        // let pointsLayerGroup = L.layerGroup().addTo(map); // Layer group untuk menyimpan markers


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
                    cachedLines = lines; // Menyimpan data ke cachedLines
                    return lines;
                })
                .catch(error => {
                    console.error('Error fetching lines:', error);
                });
        }

        // Menjalankan fetchLines sekali ketika halaman web dimuat
        document.addEventListener('DOMContentLoaded', function() {
            fetchLines();
            var checkbox = $('#mapall');

            // Pastikan elemen checkbox ditemukan
            if (checkbox.length) {
                // Set properti indeterminate jika perlu
                checkbox.prop('indeterminate', false);
            }
        });

        var $j = jQuery.noConflict();
        $j('#mapall').on('change', function() {
            var isChecked = $(this).is(':checked');

            // If mapall is checked, check both pointer and polyline
            $('#pointer').prop('checked', isChecked);
            $('#polyline').prop('checked', isChecked);
            displayLines();
            displayPoints()
        });

        // Handle change event for pointer and polyline checkboxes
        $j('#pointer, #polyline').on('change', function() {
            var isPointerChecked = $('#pointer').is(':checked');
            var isPolylineChecked = $('#polyline').is(':checked');

            // If both pointer and polyline are checked, check mapall
            if (isPointerChecked && isPolylineChecked) {
                $('#mapall').prop('checked', true);
                displayLines();
                displayPoints()
            } else {
                $('#mapall').prop('checked', false); // If either one is unchecked, uncheck mapall
                if (isPolylineChecked) {
                    displayLines();
                } else if (!isPolylineChecked) {
                    removeAllLines()
                }
                if (isPointerChecked) {
                    displayPoints();
                } else if (!isPointerChecked) {
                    removeAllPoints()
                }
            }
        });

        let pointsLayerGroup = L.layerGroup().addTo(map); // Layer group untuk menyimpan markers

        function fetchPoints() {
            return fetch('{{ url('/map/point') }}')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch points: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => data)
                .catch(error => {
                    console.error('Error fetching points:', error);
                });
        }

        function displayPoints() {
            // Hapus semua markers yang ada di layer group
            pointsLayerGroup.clearLayers();

            fetchPoints().then(points => {
                points.forEach(function(point) {
                    // Buat marker dengan popup
                    let marker = L.marker([point.latitude, point.longitude]).addTo(pointsLayerGroup);

                    // Isi konten popup dengan tombol
                    marker.bindPopup(`
                <div>
                    <button class="btn btn-primary" onclick="startPoint(${point.id}, '${point.latitude}', '${point.longitude}')">Start</button>
                    <button class="btn btn-secondary" onclick="stopPoint(${point.id}, '${point.latitude}', '${point.longitude}')">Stop</button>
                    <button class="btn btn-info" onclick="selectPoint(${point.id}, '${point.latitude}', '${point.longitude}')">Select</button>
                </div>
            `);
                });
                console.log('Get Points Data Success'); // Debugging
            });
        }

        // Fungsi untuk menangani klik tombol Start
        function startPoint(pointId, latitude, longitude) {
            console.log('Start button clicked for point ID:', pointId);
            document.getElementById('latitude').value = '';
            document.getElementById('longitude').value = '';
            document.getElementById('start-id-hidden').value = pointId;
            // Tambahkan logika untuk menangani klik tombol Start di sini
            document.getElementById('start-latitude').value = latitude;
            document.getElementById('start-longitude').value = longitude;
            let accordionElement = new bootstrap.Collapse(document.getElementById('accordionStyle1-2'), {
                toggle: true
            });
        }

        // Fungsi untuk menangani klik tombol Stop
        function stopPoint(pointId, latitude, longitude) {
            console.log('Stop button clicked for point ID:', pointId);
            // Tambahkan logika untuk menangani klik tombol Stop di sini
            const latitudeInput = document.getElementById('start-latitude');
            const longitudeInput = document.getElementById('start-longitude');

            // Cek apakah latitude dan longitude sudah diisi
            if (latitudeInput.value !== '' && longitudeInput.value !== '') {
                // Jika sudah ada nilai, tampilkan pesan atau lakukan tindakan lainnya
                console.log('Coordinates already set!');

                document.getElementById('end-id-hidden').value = pointId;
                document.getElementById('end-latitude').value = latitude;
                document.getElementById('end-longitude').value = longitude;
                // alert('Coordinates already set!');
            } else {
                // Jika belum ada nilai, set nilai latitude dan longitude
                // latitudeInput.value = latitude;
                // longitudeInput.value = longitude;
                console.log('Coordinates set:', latitude, longitude);
                Swal.fire({
                    icon: "warning",
                    title: "Oops...",
                    text: "Kamu Belum Melakukan Start Point!"
                });

            }

        }

        // Fungsi untuk menangani klik tombol Select
        function selectPoint(pointId, latitude, longitude) {
            console.log('Select button clicked for point ID:', pointId);
            document.getElementById('start-id-hidden').value = '';
            document.getElementById('end-id-hidden').value = '';
            document.getElementById('start-latitude').value = '';
            document.getElementById('start-longitude').value = '';
            document.getElementById('end-latitude').value = '';
            document.getElementById('end-longitude').value = '';
            // Isi nilai Latitude dan Longitude ke dalam input fields
            document.getElementById('latitude').value = latitude;
            document.getElementById('longitude').value = longitude;
            let accordionElement = new bootstrap.Collapse(document.getElementById('accordionStyle1-3'), {
                toggle: true
            });
        }

        function removeAllPoints() {
            // Hapus semua markers yang ada di layer group
            pointsLayerGroup.clearLayers();
        }


        function displayLines() {
            // Pastikan cachedLines sudah terisi sebelum diproses
            if (cachedLines.length === 0) {
                console.warn('No lines available in cachedLines');
                return;
            }

            // Hapus semua polylines yang ada di layer group
            polylinesGroup.clearLayers();

            cachedLines.forEach(line => {
                var coordinates = line.coordinates.map(coord => [coord.lng, coord.lat]); // Corrected lat, lng order

                if (coordinates.length > 0) {
                    console.log('Coordinates:', coordinates); // Debugging

                    // Create a polyline on the map
                    var polyline = L.polyline(coordinates, {
                        color: 'blue'
                    }).addTo(polylinesGroup); // Tambahkan ke layer group

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
                        Jumlah Tiang : ${((totalDistance * 1000) / 50).toFixed(0)} Titik<br> PU ID : 
                        ${line.name}<br>ID DB : ${line.id}<br>
                        <button class="btn btn-sm btn-outline-info" onclick="divideLine()">Buat Titik Setiap 50 Meter</button></div>`
                            )
                            .openOn(map);
                    });
                } else {
                    console.warn('No coordinates available for line:', line.name);
                }
            });
            console.log('Get Coordinates Data Success'); // Debugging
        }

        function removeAllLines() {
            // Hapus semua polylines yang ada di layer group
            polylinesGroup.clearLayers();
        }

        window.divideLine = async function() {
            var intervalDistance = 0.05; // 50 meter dalam kilometer
            var points = [];
            var lineId = window.currentLineId;
            var apiKey = "pk.5c258278302dfd852ee9af9b2547bfff"; // API key dari LocationIQ

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

                // Tambahkan marker pada peta
                var markers = L.layerGroup();

                // Async function to handle delay
                async function reverseGeocode(latlng) {
                    try {
                        const response = await fetch(
                            `https://us1.locationiq.com/v1/reverse.php?key=${apiKey}&lat=${latlng.latitude}&lon=${latlng.longitude}&format=json`
                            );
                        const data = await response.json();

                        if (data.address) {
                            var address =
                                `${data.address.road}, ${data.address.city}, ${data.address.state}, ${data.address.country}`;
                            console.log(
                                `Coordinate: (${latlng.latitude}, ${latlng.longitude}) - Address: ${address}`
                                );

                            // Menambahkan popup pada marker untuk menampilkan alamat
                            L.marker([latlng.latitude, latlng.longitude]).bindPopup(address).addTo(map);
                        } else {
                            console.warn('No address found for coordinates:', latlng);
                        }
                    } catch (error) {
                        console.error('Error fetching address:', error);
                    }
                }

                // Looping melalui poin dan memberi delay 2 detik antara setiap panggilan API
                for (let latlng of points) {
                    markers.addLayer(L.marker([latlng.latitude, latlng.longitude]));

                    // Memanggil fungsi reverseGeocode dengan delay 2 detik
                    await reverseGeocode(latlng);
                    await new Promise(resolve => setTimeout(resolve, 2000)); // Delay 2 detik
                }

                markers.addTo(map);
            } else {
                console.warn('No current GeoJSON line found');
            }
        };
    </script>
@endsection
