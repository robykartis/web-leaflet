@extends('layouts.main')

@push('css')
<style>
    .custom-popup-image {
        width: 100%;
        /* Ukuran lebar maksimum dalam kontainer popup */
        height: auto;
        /* Menjaga proporsi aspek gambar */
        max-width: none;
    }
</style>
@endpush
@section('content')
<section>
    <div class="flex flex-row flex-wrap flex-grow p-2">
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="card w-full bg-base-100 shadow-xl">
                <div class="card-body">
                    <div id="map" class="rounded-lg" style="width: 100%; height: 500px;"></div>
                </div>
            </div>
            <!--/table Card-->
        </div>
    </div>
</section>
@endsection
@push('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src='https://unpkg.com/leaflet-control-geocoder@2.4.0/dist/Control.Geocoder.js'></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet-search@3.0.9/dist/leaflet-search.src.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet.fullscreen@2.4.0/Control.FullScreen.min.js"></script>

<script>
    let map, markers = [];
    /* ----------------------------- Initialize Map ----------------------------- */
    function initMap() {
        map = L.map('map', {
            center: {
                lat: 0.4888556,
                lng: 101.4548226,
            },
            zoom: 10
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        map.on('click', mapClicked);
        fetchMapData().then(data => {
            initMarkers(data);
        });
    }
    initMap();

    /* --------------------------- Initialize Markers --------------------------- */
    function initMarkers(data) {
    for (let index = 0; index < data.length; index++) {
        const markerData = data[index];
        const marker = generateMarker(markerData, index);
        marker.on('mouseover', () => {
            marker.openPopup();
        });
        marker.on('mouseout', () => {
            marker.closePopup();
        });
        marker.addTo(map)
        marker.bindPopup(`
            <img src="assets/image/mark/${markerData.position.image}" alt="Shoes" class="rounded-xl custom-popup-image" />
            <h2 class="card-title">${markerData.position.title}</h2>
            <p>${markerData.position.description}</p>
        `);

        map.panTo(markerData.position);
        markers.push(marker);
    }
}

    function generateMarker(data, index) {
        return L.marker(data.position, {
            draggable: false 
        })
            .on('click', (event) => markerClicked(event, index))
            .on('dragend', (event) => markerDragEnd(event, index));
    }

    /* ------------------------- Handle Map Click Event ------------------------- */
    function mapClicked($event) {
        console.log(map);
        console.log($event.latlng.lat, $event.latlng.lng);
    }

    /* ------------------------ Handle Marker Click Event ----------------------- */
    function markerClicked($event, index) {
        console.log(map);
        console.log($event.latlng.lat, $event.latlng.lng);
    }

    /* ----------------------- Handle Marker DragEnd Event ---------------------- */
    function markerDragEnd($event, index) {
        console.log(map);
        console.log($event.target.getLatLng());
    }

    /* ----------------------------- Fetch Map Data ----------------------------- */
    function fetchMapData() {
        return fetch('/api/maps') // Ganti dengan URL yang sesuai dengan rute API Anda.
            .then(response => response.json())
            .then(data => {
                return data.data.initialMarkers.position;
            })
            .catch(error => {
                console.error('Gagal mengambil data peta:', error);
            });
    }
</script>

@endpush